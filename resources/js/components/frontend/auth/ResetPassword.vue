<template>
  <div>
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content w-50 mx-auto mt-5">
      <b-card v-if="isVerified" header="New Password" class="border-0 shadow">
        <div class="md-title"></div>
        <b-button @click="$router.back()" class="md-icon-button close"
          ><b-icon icon="x"></b-icon
        ></b-button>
        <form @submit.prevent="submit">
          <b-form-group>
            <b-form-input
              type="password"
              v-model="form.password"
              required
              placeholder="New password"
            ></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-input
              type="password"
              v-model="form.password_confirmation"
              required
              placeholder="Confirm password"
            ></b-form-input>
          </b-form-group>
          <div class="text-right">
            <b-spinner variant="primary" v-if="loading"></b-spinner>
            <b-button v-else type="submit" variant="primary">Submit</b-button>
          </div>
        </form>
      </b-card>
      <b-card v-else header="Verification code" class="border-0 shadow">
        <div class="md-title"></div>
        <b-button @click="$router.back()" class="md-icon-button close"
          ><b-icon icon="x"></b-icon
        ></b-button>
        <form @submit.prevent="verify">
          <p>Enter the verification code</p>
          <CodeInput
            :loading="false"
            class="input"
            :fields="4"
            :fieldWidth="80"
            v-on:change="onChange"
            v-on:complete="verify"
          />
          <p class="blockquote-footer">We texted a code to your email!</p>
          <p style="color: red" v-if="invalidCode">{{ invalidCode }}</p>
          <div class="mt-3 text-right">
            <b-spinner variant="primary" v-if="loading"></b-spinner>
            <b-button v-if="resend" @click="$router.back()" variant="primary"
              >Reverify</b-button
            >
          </div>
        </form>
      </b-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import axio from "axios";
import CodeInput from "vue-verification-code-input";
import { mapActions, mapGetters } from "vuex";
import Toaster from "../../shared/Toaster";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
export default {
  name: "Login",
  data: () => ({
    form: {
      email: localData.read("temp"),
      password: null,
      password_confirmation: null,
    },
    loading: false,
    isVerified: false,
    invalidCode: null,
    resend: false,
  }),
  methods: {
    onChange() {},
    verify(v) {
      this.loading = true;
      axio
        .post("password/verify", { code: v, email: localData.read("temp") })
        .then((res) => {
          console.log("res", res.data);
          this.loading = false;
          this.isVerified = true;
        })
        .catch((err) => {
          this.loading = false;
          this.resend = true;
          this.invalidCode = err.response.data.error;
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Faild",
            err.response.data.error
          );
        });
    },
    submit() {
      this.loading = true;
      axio
        .post("password/reset", this.form)
        .then((res) => {
          console.log("res", res.data);
          this.loading = false;
          this.$router.push("/password");
        })
        .catch((err) => {
          this.loading = false;
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Faild",
            err.response.data.error.password_confirmation
          );
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
    Toaster,
    Header,
    Footer,
    CodeInput,
  },
};
</script>

<style lang="scss" scoped>
.content {
  min-height: calc(100vh - 50px);

  .close {
    position: absolute;
    right: 0;
    top: 0;
  }
}
@media only screen and (max-width: 600px) {
  .login {
    padding-top: 3em;

    .md-card {
      .login-througth {
        .b-button {
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
