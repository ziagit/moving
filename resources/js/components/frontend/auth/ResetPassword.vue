<template>
  <div>
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content w-25 mx-auto mt-5">
      <b-card header="New Password" class="border-0 shadow">
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
      password: null,
      password_confirmation: null,
      token: null,
    },
    loading: false,
    orderExist: false,
  }),
  methods: {
    submit() {
      this.loading = true;
      axio
        .post("reset-password", this.form)
        .then((res) => {
          this.loading = false;
          this.$router.push("/password");
        })
        .catch((err) => {
          this.errMessage = err.response.data.message;
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
