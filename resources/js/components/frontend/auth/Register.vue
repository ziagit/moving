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
              <label>Email/Phone</label>
              <md-input v-model="form.email" required></md-input>
            </md-field>
            <md-field>
              <label>Password</label>
              <md-input v-model="form.password" required type="password"></md-input>
            </md-field>
            <md-field>
              <label>Confirm password</label>
              <md-input
                v-model="form.password_confirmation"
                required
                type="password"
              ></md-input>
            </md-field>
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
            <router-link to="/login-mover">Sign in instead</router-link>
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
import axios from "axios";
import localData from "../services/localData";
export default {
  name: "SignUp",
  data: () => ({
    form: {
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      type: "mover",
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
      if (this.form.password !== this.form.password_confirmation) {
        this.snackbar.show = true;
        this.snackbar.statusCode = 400;
        this.snackbar.message = "Passwords not matching!";
      } else {
        this.isSubmitting = true;
        axios
          .post("auth/verify-email", this.form)
          .then((res) => {
            console.log("user created: ", res.data);
            localData.save("me", res.data);
            this.$router.push("verify");
            this.isSubmitting = false;
            //this.$router.push("welcome");
          })
          .catch((error) => {
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
    },
  },
  mounted() {
    this.$refs.focusable.$el.focus();
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
