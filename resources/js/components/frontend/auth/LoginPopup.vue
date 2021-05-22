<template>
  <div class="container">
    <div class="content">
      <md-card mode="ios">
        <md-card-header>
          <div class="md-title">Login</div>
        </md-card-header>
        <md-card-content>
          <Spinner v-if="dataLoading" />
          <form @submit.prevent="submit">
            <md-field>
              <label>Username</label>
              <md-input type="email" v-model="form.email" required></md-input>
            </md-field>
            <md-field>
              <label>Password</label>
              <md-input type="password" v-model="form.password" required></md-input>
            </md-field>
            <md-button type="submit" class="md-primary">Login</md-button>
          </form>
          <md-button to="/register" class="md-primary">Register</md-button>
        </md-card-content>
        <div class="login-througth">
          <md-button to="/order/card-details" class="primary" v-if="orderExist"
            >Continue as guest</md-button
          >
          <md-button to="/forgot-password" class="primary">Reset Password</md-button>
        </div>
      </md-card>
    </div>
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
      password: null,
    },
    dataLoading: false,
    orderExist: false,
  }),
  methods: {
    test() {
      console.log("hi");
    },
    ...mapActions({
      signIn: "auth/signIn",
    }),
    submit() {
      if (!this.authenticated) {
        this.dataLoading = true;
        this.signIn(this.form)
          .then((res) => {
            switch (this.user.role[0].name) {
              case "mover":
                axios.get("carrier/details").then((res) => {
                  res.data.first_name !== undefined
                    ? this.$router.push(this.$route.query.redirect || "/")
                    : this.$router.push("/carrier/profile/add");
                });
                break;
              case "customer":
                axios.get("shipper/details").then((res) => {
                  this.$router.push("/order/moving-payment");
                  /*   res.data.first_name !== undefined
                    ? this.$router.push(this.$route.query.redirect || "/")
                    : this.$router.push("/shipper/profile/add"); */
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
            this.snackbar.message = error.response.data;
            this.snackbar.statusCode = error.response.status;
            this.snackbar.show = true;
            this.dataLoading = false;
          });
      } else {
        this.snackbar.show = true;
        this.snackbar.statusCode = "";
        this.snackbar.message = "You are already logedin.";
      }
    },

    init() {
      this.orderExist = localData.read("carrier");
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  created() {
    this.init();
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
      min-width: 400px;
      margin: auto;
      text-align: center;
      background: #fff;
      max-width: 500px;
      box-shadow: none !important;

      .md-card-content {
        padding: 20px;
      }

      .login-througth {
        width: 100%;
        display: flex;
        justify-content: space-between;

        .md-button {
          font-size: 8px;
        }

        ion-label {
          font-size: 12px;
        }
      }

      .md-display-1 {
        font-size: 24px;
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .container {
    .content {
      .md-card {
        min-width: 300px !important;
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
}
</style>
