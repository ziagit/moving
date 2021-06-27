<template>
  <div class="register">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <b-card
        title="TingsApp"
        sub-title="Create new account"
        class="border-0 shadow w-50 mx-auto"
      >
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="break"></div>
          <b-form-group id="fieldset-1" label-for="input-1">
            <b-form-input
              id="input-1"
              v-model="form.name"
              placeholder="Name"
              required
              ref="focusable"
            ></b-form-input>
          </b-form-group>
          <b-form-group id="fieldset-1" label-for="input-1">
            <b-form-input
              id="input-1"
              v-model="form.email"
              type="email"
              placeholder="Email/phone"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group id="fieldset-1" label-for="input-1">
            <b-form-input
              id="input-1"
              type="password"
              v-model="form.password"
              placeholder="Password"
              required
            ></b-form-input>
          </b-form-group>
          <b-form-group id="fieldset-1" label-for="input-1">
            <b-form-input
              id="input-1"
              type="password"
              v-model="form.password_confirmation"
              placeholder="Password confirmation"
              required
            ></b-form-input>
          </b-form-group>
          <div class="break"></div>
          <div class="submit">
            <b-form-checkbox
              id="checkbox-1"
              v-model="agreement"
              name="checkbox-1"
              value="accepted"
              :unchecked-value="false"
            >
              I accept the terms and use
            </b-form-checkbox>
            <div class="action">
              <b-spinner v-if="isSubmitting" variant="primary"></b-spinner>
              <b-button :disabled="!agreement" v-else type="submit" variant="primary"
                >Submit
              </b-button>
            </div>
          </div>
        </form>

        <template #footer>
          <small class="primary" @click="$router.push('/login')">Sign in instead</small>
        </template>
      </b-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Toaster from "../../shared/Toaster";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import axios from "axios";
import localData from "../services/localData";
export default {
  name: "SignUp",
  data: () => ({
    agreement: false,
    form: {
      name: null,
      email: null,
      password: null,
      password_confirmation: null,
      type: "mover",
    },
    isSubmitting: false,
    passwordTogal: false,
  }),
  methods: {
    ...mapActions({
      signUp: "auth/signUp",
    }),
    submit() {
      if (this.form.password !== this.form.password_confirmation) {
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-right",
          "Warning",
          "Passwords not matching!"
        );
      } else {
        this.isSubmitting = true;
        axios
          .post("auth/verify-email", this.form)
          .then((res) => {
            this.isSubmitting = false;
            console.log("user created: ", res.data);
            if (res.status == 203) {
              this.$refs.toaster.show(
                "danger",
                "b-toaster-top-center",
                "Error",
                res.data
              );
            } else {
              localData.save("me", res.data);
              this.$router.push("verify");
            }
          })
          .catch((err) => {
            console.log(err.response.data);
            this.isSubmitting = false;
            if (err.response.status === 409) {
              this.$refs.toaster.show(
                "danger",
                "b-toaster-top-center",
                "Conflict",
                err.response.data.error.email[0]
              );
            } else {
              this.$refs.toaster.show(
                "danger",
                "b-toaster-top-center",
                "Faild",
                err.response.data.error
              );
            }
          });
      }
    },
  },
  mounted() {
    this.$refs.focusable.focus();
  },
  components: {
    Header,
    Footer,
    Toaster,
  },
};
</script>

<style lang="scss" scoped>
.register {
  .content {
    padding: 60px 20px;
    height: calc(100vh - 3px);
    .submit {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    small:hover {
      cursor: pointer;
      color: #007bff;
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
