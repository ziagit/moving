<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card>
        <md-card-header>
          <div class="md-title">TingsApp</div>
        </md-card-header>
        <md-card-content>
          <div class="break"></div>
          <div class="md-body-2">Enter the verification code</div>
          <div class="md-caption">We texted a code to your email/phone number</div>
          <div class="break"></div>
          <CodeInput
            :loading="false"
            class="input"
            :fields="4"
            :fieldWidth="80"
            v-on:change="onChange"
            v-on:complete="verify"
          />
          <div class="resend">
            <p>Code not received?</p>
            <md-button class="md-primary" to="/login">Resend</md-button>
          </div>
          <p class="md-caption">Test code: 0-0-0-0</p>
          <p style="color: red" v-if="invalidCode">{{ invalidCode }}</p>
          <Spinner v-if="isSubmitting" />
        </md-card-content>
      </md-card>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import CodeInput from "vue-verification-code-input";
import { mapActions, mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
export default {
  name: "SignUp",
  components: {
    Spinner,
    Snackbar,
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
      console.log("onChange ", v);
    },
    verify(v) {
      this.isSubmitting = true;
      this.invalidCode = null;
      this.signIn({ code: v, me: this.me })
        .then((res) => {
          this.isSubmitting = false;
          localData.remove("me");
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
            default:
              this.$router.push("/");
          }
        })
        .catch((error) => {
          this.invalidCode = v + " is not valid, please check your phone!";
          console.log("err: ", error.response);
          localData.remove("me");
          this.isSubmitting = false;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.message = error.response.data;
          this.snackbar.show = true;
        });
    },
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
      padding: 20px;
    }
    .resend {
      display: flex;
      align-items: center;
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
