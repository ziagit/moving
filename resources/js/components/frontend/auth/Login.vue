<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card mode="ios">
        <md-card-header>
          <div class="md-title">TingsApp</div>
        </md-card-header>
        <md-card-content>
          <div class="md-body-2">Hi!</div>
          <div class="md-body-1">Let us verify your phone number</div>
          <div class="break"></div>
          <form @submit.prevent="submit">
            <VuePhoneNumberInput
              v-model="form.formatted"
              default-country-code="CA"
              :no-country-selector="true"
              :required="true"
              error-color="#e42c2c"
              :no-validator-state="true"
              v-on:update="update"
              :border-radius="1"
            />
            <!--     <input type="text" v-model="form.phone" /> -->
            <div class="break"></div>
            <div class="break"></div>
            <div class="action">
              <Spinner v-if="dataLoading" />
              <md-button
                v-else
                type="submit"
                class="md-raised md-fab md-icon-button rounded-secondary-button"
              >
                <md-icon>arrow_forward</md-icon>
              </md-button>
            </div>
          </form>
        </md-card-content>
      </md-card>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import VuePhoneNumberInput from "vue-phone-number-input";
import { mapActions, mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
import functions from "../services/functions";
export default {
  name: "Login",
  components: {
    Spinner,
    Snackbar,
    Header,
    Footer,
    VuePhoneNumberInput,
  },
  data: () => ({
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
    form: {
      name: "Customer",
      phone: null,
      type: "customer",
    },
    dataLoading: false,
  }),
  methods: {
    update(v) {
      this.form.phone = v.isValid ? v.formattedNumber : null;
    },
    submit() {
      if (!this.authenticated) {
        if (!this.form.phone) {
          this.snackbar.message = "Invalid phone number provided!";
          this.snackbar.statusCode = 400;
          this.snackbar.show = true;
        } else {
          this.dataLoading = true;
          axios
            .post("auth/verify", this.form)
            .then((res) => {
              console.log("res: ", res.data);
              localData.save("me", res.data);
              this.isSubmitting = false;
              this.$router.push("verify");
            })
            .catch((error) => {
              console.log("error", error);
              this.snackbar.message = error.response.data;
              this.snackbar.statusCode = error.response.status;
              this.snackbar.show = true;
              this.dataLoading = false;
            });
        }
      } else {
        this.snackbar.show = true;
        this.snackbar.statusCode = "";
        this.snackbar.message = "You are already logedin.";
      }
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
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
      padding: 20px;
      margin: auto;
      max-width: 500px;
      .action {
        text-align: center;
      }
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
