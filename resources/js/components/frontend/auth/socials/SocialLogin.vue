<template>
  <div class="register">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <b-card
        title="TingsApp"
        sub-title="Social login"
        class="border-0 shadow w-50 mx-auto mt-5"
      >
        <div class="mt-5">
          <p>Choose and account</p>
          <div class="row mb-3">
            <b-button class="col-12" variant="danger" @click="google()">
              <span>GOOGLE</span>
            </b-button>
          </div>
          <div class="row mb-3">
            <b-button class="col-12" variant="primary">
              <span>FACEBOOK</span>
            </b-button>
          </div>
          <div class="row">
            <b-button class="col-12" variant="info">
              <span>TWITTER</span>
            </b-button>
          </div>
        </div>
        <div>
          <b-button @click="send()">Send email</b-button>
        </div>
        <template #footer>
          <b-icon icon="chevron-compact-left"></b-icon>
        </template>
      </b-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import { mapActions } from "vuex";
import Toaster from "../../../shared/Toaster";
import Header from "../../../shared/Header";
import Footer from "../../../shared/Footer";
import axios from "axios";
export default {
  name: "SignUp",
  data: () => ({
    isSubmitting: false,
  }),
  methods: {
    ...mapActions({
      signInGoogl: "auth/signInGoogl",
    }),
    google() {
      this.signInGoogl().then((res) => {
        if (res.data) {
          window.location.href = res.data.url;
          console.log("url:", res.data.url);
        }
      });
    },
    send() {
      axios
        .get("tests")
        .then((res) => {
          console.log("tests", res.data);
        })
        .catch((err) => console.log(err));
    },
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
    min-height: calc(100vh - 50px);
  }
}

@media only screen and (max-width: 600px) {
}
</style>
