<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card mode="ios">
        <md-card-header>
          <div class="md-title">You forgot your password?</div>
          <div class="message" v-if="message">{{ message }}</div>
          <md-button @click="$router.back()" class="md-icon-button close"
            ><md-icon>close</md-icon></md-button
          >
        </md-card-header>
        <md-card-content>
          <form @submit.prevent="submit">
            <md-field>
              <label>Type your email</label>
              <md-input type="email" v-model="form.email" required></md-input>
            </md-field>
            <b-spinner variant="primary" v-if="loading" />

            <md-button v-else type="submit" class="md-primary">Send reset link</md-button>
          </form>
        </md-card-content>
      </md-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import axio from "axios";
import { mapActions, mapGetters } from "vuex";
import Toaster from "../../shared/Toaster";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
export default {
  name: "Login",
  data: () => ({
    form: {
      email: null,
    },
    message: null,
    loading: false,
  }),
  methods: {
    submit() {
      this.loading = true;
      axio
        .post("forgot-password", this.form)
        .then((res) => {
          this.message = res.data.message;
          this.errMessage = null;
          this.loading = false;
          console.log("forgot pass res ", res.data.message);
        })
        .catch((err) => {
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            err.response.data
          );
          this.loading = false;
          console.log(err.response.data.message);
        });
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  created() {},
  components: {
    Toaster,
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
      .message {
        color: green;
      }
      .err-message {
        color: red;
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
