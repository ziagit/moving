<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card mode="ios">
        <md-card-header>
          <span class="md-title">TingsApp</span>
        </md-card-header>
        <md-card-content>
          <div class="break"></div>
          <form @submit.prevent="submitPassword" v-if="inputTogal">
            <div class="md-body-2">Almost there</div>
            <div class="md-body-1">Please enter your password</div>
            <md-field>
              <label>Password</label>
              <md-input type="password" v-model="form.password" required></md-input>
            </md-field>
            <div class="submit">
              <Spinner v-if="isSubmitting" />
              <md-button
                v-else
                type="submit"
                class="md-raised md-fab md-icon-button rounded-secondary-button"
              >
                <md-icon>arrow_forward</md-icon>
              </md-button>
            </div>
          </form>
          <form @submit.prevent="submit" v-else>
            <div class="md-body-2">Welcome back</div>
            <div class="md-body-1">Enter your email or phone number</div>
            <md-field>
              <label>Email/phone</label>
              <md-input type="text" v-model="form.email" required></md-input>
            </md-field>
            <div class="submit">
              <Spinner v-if="isSubmitting" />
              <md-button
                v-else
                type="submit"
                class="md-raised md-fab md-icon-button rounded-secondary-button"
              >
                <md-icon>arrow_forward</md-icon>
              </md-button>
            </div>
          </form>
        </md-card-content>
        <md-card-actions md-alignment="space-between">
          <md-button to="/forgot-password" class="md-primary" v-show="inputTogal"
            >Reset Password</md-button
          >
          <md-button to="/register" class="md-secondary">New mover</md-button>
        </md-card-actions>
      </md-card>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
import axios from "axios";
export default {
  name: "Login",
  data: () => ({
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
    form: {
      email: null,
    },
    isSubmitting: false,
  }),
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),
    submit() {
      if (!this.authenticated) {
        this.isSubmitting = true;
        axios
          .post("auth/check-email", this.form)
          .then((res) => {
            this.isSubmitting = false;
            localData.save("me", res.data.id);
            if (res.data.status == "email") {
              this.$router.push("/password");
            } else {
              this.$router.push("/verify");
            }
          })
          .catch((err) => {
            this.snackbar.message = err.response.data;
            this.snackbar.statusCode = err.response.status;
            this.snackbar.show = true;
            this.isSubmitting = false;
          });
      }
    },
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
      text-align: left;
      max-width: 500px;
      padding: 20px;

      .md-card-content {
        .submit {
          text-align: right;
        }
      }

      .login-througth {
        width: 100%;
        display: flex;
        justify-content: space-between;
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
