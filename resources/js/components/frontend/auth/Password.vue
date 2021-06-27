<template>
  <div class="password">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <b-card
        title="TingsApp"
        sub-title="Almost there"
        class="border-0 shadow w-50 mx-auto"
      >
        <form @submit.prevent="submit">
          <b-form-group
            id="fieldset-1"
            description="Your phone number will not be shared!"
            label=""
            label-for="input-1"
            valid-feedback="Thank you!"
          >
            <div class="break"></div>
            <span>Enter your password</span>
            <b-form-input
              id="input-1"
              type="password"
              v-model="form.password"
              required
            ></b-form-input>
          </b-form-group>

          <div class="submit">
            <b-spinner variant="primary" v-if="isSubmitting" />
            <b-button v-else type="submit" variant="primary"> Submit </b-button>
          </div>
        </form>
        <template #footer>
          <b-button variant="light" size="sm" @click="$router.push('/forgot-password')"
            >Reset Password</b-button
          >
        </template>
      </b-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Toaster from "../../shared/Toaster";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import axios from "axios";
import localData from "../services/localData";
export default {
  name: "Login",
  data: () => ({
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
            case "support":
              this.$router.push("/admin");
              break;
            case "admin":
              this.$router.push("/admin");
              break;
            default:
              this.$router.push("/");
          }
        })
        .catch((err) => {
          console.log("errrr", err.response.data);
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Faild",
            err.response.data.message
          );
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
    Toaster,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.password {
  .content {
    padding: 60px 20px;
    height: calc(100vh - 3px);
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

@media only screen and (max-width: 600px) {
}
</style>
