<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card mode="ios">
        <md-card-header>
          <div class="md-title">Reset Password</div>
          <md-button @click="$router.back()" class="md-icon-button close"
            ><md-icon>close</md-icon></md-button
          >
        </md-card-header>
        <md-card-content>
          <form @submit.prevent="submit">
            <md-field>
              <label>New password</label>
              <md-input type="password" v-model="form.password" required></md-input>
            </md-field>
            <md-field>
              <label>Confirm password</label>
              <md-input
                type="password"
                v-model="form.password_confirmation"
                required
              ></md-input>
            </md-field>
            <Spinner v-if="loading" />

            <md-button v-else type="submit" class="md-primary">Reset</md-button>
          </form>
        </md-card-content>
      </md-card>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axio from "axios";
import { mapActions, mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
export default {
  name: "Login",
  data: () => ({
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
    form: {
      password: null,
      password_confirmation: null,
      token: null,
    },
    loading: false,
    orderExist: false,
  }),
  methods: {
    submit() {
      this.loading = true;
      axio
        .post("reset-password", this.form)
        .then((res) => {
          this.loading = false;
          this.$router.push("/login");
        })
        .catch((err) => {
          this.errMessage = err.response.data.message;
          this.loading = false;
          this.snackbar.show = true;
          this.snackbar.message = err.response.data.error.password_confirmation;
          this.snackbar.statusCode = err.response.status;
          console.log(err.response);
        });
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  created() {
    this.form.token = this.$route.params.token;
  },
  components: {
    Spinner,
    Snackbar,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.container {
  width: 100%;

  .content {
    padding: 60px 20px;
    height: calc(100vh - 3px);

    .md-card {
      margin: auto;
      text-align: center;
      background: #fff;
      max-width: 500px;

      .md-card-content {
        padding: 20px;
      }

      .md-display-1 {
        font-size: 24px;
      }
      .close {
        position: absolute;
        right: 0;
        top: 0;
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .login {
    padding-top: 3em;

    .md-card {
      .login-througth {
        .md-button {
          font-size: 11px;
        }
      }

      .md-display-1 {
        font-size: 30px;
      }
    }
  }
}
</style>
