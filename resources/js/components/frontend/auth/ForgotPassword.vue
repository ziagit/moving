<template>
  <div class="">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content w-25 mx-auto mt-5">
      <b-card header="You forgot your password?" class="shadow border-0">
        <b-button @click="$router.back()" class="md-icon-button close"
          ><b-icon icon="x"></b-icon
        ></b-button>
        <div>
          <div class="message" v-if="message">{{ message }}</div>
          <form @submit.prevent="submit">
            <b-form-group>
              <b-form-input
                type="email"
                v-model="form.email"
                required
                placeholder="Enter your email"
              ></b-form-input>
            </b-form-group>
            <b-spinner variant="primary" v-if="loading" />
            <b-button v-else type="submit" variant="primary">Send reset link</b-button>
          </form>
        </div>
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
      email: null,
    },
    message: null,
    loading: false,
  }),
  methods: {
    submit() {
      this.loading = true;
      axio
        .post("forgot-password", this.form)
        .then((res) => {
          this.message = res.data.message;
          this.errMessage = null;
          this.loading = false;
          console.log("forgot pass res ", res.data);
        })
        .catch((err) => {
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            err.response.data.message
          );
          this.loading = false;
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
  created() {},
  components: {
    Toaster,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.content {
  height: calc(100vh - 3px);

  .close {
    position: absolute;
    right: 0;
    top: 0;
  }
  .message {
    color: green;
  }
  .err-message {
    color: red;
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
