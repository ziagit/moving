<template>
  <div class="verify">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <b-card title="TingsApp" class="border-0 shadow w-50 mx-auto">
        <div class="break"></div>
        <div class="body-2">Enter the verification code</div>
        <div class="break"></div>
        <CodeInput
          :loading="false"
          class="input"
          :fields="4"
          :fieldWidth="80"
          v-on:change="onChange"
          v-on:complete="verify"
        />
        <div class="caption">We texted a code to your email & phone number</div>
        <div class="break"></div>

        <p class="md-caption">Test code: 0-0-0-0</p>
        <p style="color: red" v-if="invalidCode">{{ invalidCode }}</p>
        <b-spinner variant="primary" v-if="isSubmitting"></b-spinner>
        <template #footer>
          <small variant="light" @click="$router.push('/login')" class="resend"
            >Resnd</small
          >
        </template>
      </b-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import CodeInput from "vue-verification-code-input";
import { mapActions, mapGetters } from "vuex";
import Toaster from "../../shared/Toaster";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
export default {
  name: "SignUp",
  components: {
    Toaster,
    Header,
    Footer,
    CodeInput,
  },
  data: () => ({
    me: null,
    isSubmitting: false,
    invalidCode: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    console.log("user", this.user);
  },
  mounted() {
    this.me = localData.read("me");
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    ...mapActions({
      signIn: "auth/signIn",
    }),
    onChange(v) {
      //
    },
    verify(v) {
      this.isSubmitting = true;
      this.invalidCode = null;
      this.signIn({ code: v, me: this.me })
        .then((res) => {
          this.isSubmitting = false;
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
            case "admin":
              this.$router.push("/admin");
              break;
            case "support":
              this.$router.push("/admin");
              break;
            default:
              this.$router.push("/");
          }
        })
        .catch((error) => {
          this.invalidCode = v + " is not valid, please check your phone!";
          console.log("err: ", error.response);
          localData.remove("me");
          this.isSubmitting = false;
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Faild",
            error.response.data
          );
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.verify {
  width: 100%;
  .content {
    padding: 60px 20px;
    height: calc(100vh - 3px);
    .resend {
      display: flex;
      align-items: center;
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
