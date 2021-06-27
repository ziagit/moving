<template>
  <div class="login">
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
            description="Your phone/email number will not be shared!"
            label=""
            label-for="input-1"
            valid-feedback="Thank you!"
          >
            <div class="break"></div>
            <span>Enter your email or phone number</span>
            <b-form-input id="input-1" v-model="form.email" required></b-form-input>
          </b-form-group>
          <div class="submit">
            <b-spinner variant="primary" v-if="isSubmitting" />
            <b-button v-else type="submit" variant="primary"> Signin </b-button>
          </div>
        </form>
        <template #footer>
          <p>Login using:</p>
          <b-button variant="outline-danger" size="sm">Gmail</b-button>
          <b-button variant="outline-primary" size="sm">Facebook</b-button>
          <b-button variant="outline-info" size="sm">Twitter</b-button>
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
import localData from "../services/localData";
import axios from "axios";
export default {
  name: "Login",
  data: () => ({
    form: {
      email: null,
    },
    inputTogal: false,
    isSubmitting: false,
  }),
  computed: {},

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
            console.log("login page", res.data);
            this.isSubmitting = false;
            localData.save("me", res.data.id);
            if (res.data.status == "email") {
              this.$router.push("/password");
            } else {
              this.$router.push("/verify");
            }
          })
          .catch((err) => {
            this.isSubmitting = false;
            this.$refs.toaster.show(
              "danger",
              "b-toaster-top-center",
              "Error",
              err.response.data
            );
          });
      }
    },
  },

  components: {
    Toaster,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.login {
  width: 100%;

  .content {
    padding: 60px 20px;
    height: calc(100vh - 3px);

    .submit {
      text-align: right;
    }
    small:hover {
      cursor: pointer;
      color: #007bff;
    }
  }
}
</style>
