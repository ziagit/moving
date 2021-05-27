<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card>
        <md-card-header>
          <div class="md-title">Register</div>
        </md-card-header>
        <md-card-content>
          <form @submit.prevent="submit" enctype="multipart/form-data">
            <md-field>
              <label>Name</label>
              <md-input v-model="form.name" required ref="focusable"></md-input>
            </md-field>
            <md-field>
              <label>Phone</label>
              <md-input v-model="form.phone" required></md-input>
            </md-field>
            <div>
              <md-radio v-model="form.type" value="mover">Mover</md-radio>
              <md-radio v-model="form.type" value="customer">Customer</md-radio>
            </div>
            <div class="submit">
              <p>
                <span>&#8226;</span> By clicking submit you will agree to our terms and
                conditions.
              </p>
              <Spinner v-if="isSubmitting" />
              <md-button v-else type="submit" class="custom-button">Submit</md-button>
            </div>
          </form>
          <div class="login">
            <router-link to="/login">Sign in instead</router-link>
          </div>
        </md-card-content>
      </md-card>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
import functions from "../services/functions";
export default {
  name: "SignUp",
  components: {
    Spinner,
    Snackbar,
    Header,
    Footer,
  },
  data: () => ({
    form: {
      name: null,
      phone: null,
      type: "customer",
    },
    isSubmitting: false,
    passwordTogal: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  methods: {
    ...mapActions({
      signUp: "auth/signUp",
    }),
    submit() {
      if (
        this.form.phone == null ||
        this.form.name == null ||
        !functions.phoneValidator(this.form.phone)
      ) {
        this.snackbar.message = "Invalid phone number provided!";
        this.snackbar.statusCode = 400;
        this.snackbar.show = true;
      } else {
        this.isSubmitting = true;
        axios
          .post("auth/verify/", this.form)
          .then((res) => {
            localData.save("me", res.data);
            this.isSubmitting = false;
            this.$router.push("verify");
          })
          .catch((error) => {
            console.log("errr", error.response);
            this.isSubmitting = false;
            this.snackbar.message = error.response.data.phone;
            this.snackbar.statusCode = error.response.status;
            this.snackbar.show = true;
          });
      }
    },
    /*     submit() {
      if (this.form.password !== this.form.password_confirmation) {
        this.snackbar.show = true;
        this.snackbar.statusCode = 400;
        this.snackbar.message = "Passwords not matching!";
      } else {
        this.isSubmitting = true;
        this.signUp(this.form)
          .then((res) => {
            console.log("res", res.data);
            this.isSubmitting = false;
            this.$router.push("welcome");
          })
          .catch((error) => {
            console.log("errr", error);
            this.isSubmitting = false;
            if (error.response.status === 409) {
              this.snackbar.statusCode = error.response.status;
              this.snackbar.message = error.response.data.error;
            } else {
              this.snackbar.statusCode = error.response.status;
              this.snackbar.message = error.response.data.error;
            }
            this.snackbar.show = true;
          });
      }
    }, */
  },
  mounted() {
    this.$refs.focusable.$el.focus();
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
      max-width: 500px;
      margin: auto;
      text-align: center;
      background: #fff;

      .md-card-content {
        padding: 20px;
        .submit {
          display: flex;
          justify-content: space-between;
          p {
            text-align: left;
            font-size: 11px;
            display: flex;
            span {
              font-size: 26px;
              color: #ffa500;
            }
          }
          .custom-button {
            box-shadow: none;
          }
        }
        .login {
          text-align: left;
        }
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .register {
    .md-card {
      margin-top: 3em;

      .other-way {
        .md-button {
          font-size: 11px;
        }
      }
    }
  }
}
</style>
