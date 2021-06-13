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
          <form @submit.prevent="submit">
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
        </md-card-content>
        <md-card-actions md-alignment="space-between">
          <md-button to="/forgot-password" class="md-primary">Reset Password</md-button>
          <md-button to="/register" class="md-secondary">New Mover</md-button>
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
import axios from "axios";
import localData from "../services/localData";
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
      me: localData.read("me"),
    },
    isSubmitting: false,
  }),
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),

    submit() {
      this.isSubmitting = true;
      this.signIn(this.form)
        .then((res) => {
          console.log("88888888888888", res.d);
          switch (this.user.role[0].name) {
            case "mover":
              axios.get("carrier/details").then((res) => {
                res.data.first_name !== undefined
                  ? this.$router.push(this.$route.query.redirect || "/carrier/dashboard")
                  : this.$router.push("/carrier/profile/add");
              });
              break;
            case "customer":
              axios.get("shipper/details").then((res) => {
                res.data.first_name !== undefined
                  ? this.$router.push(this.$route.query.redirect || "/")
                  : this.$router.push("/shipper/profile/add");
              });
              break;
            case "admin":
              this.$router.push("/admin");
              break;
            default:
              this.$router.push("/");
          }
        })
        .catch((error) => {
          console.log("errrr", error);
          localData.remove("me");
          this.snackbar.message = error.response.data;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
          this.isSubmitting = false;
        });
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
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
