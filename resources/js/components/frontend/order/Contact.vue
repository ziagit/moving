<template>
  <div class="contact">
    <div>
      <div v-if="me">
        <span class="md-display-1">Enter verification code</span>
        <div class="break"></div>
        <div class="break"></div>
        <md-card>
          <md-card-content>
            <CodeInput
              :loading="false"
              class="input"
              :fields="4"
              :fieldWidth="60"
              v-on:change="onChange"
              v-on:complete="verify"
            />
            <p class="md-caption">We texted a code to your phone number.</p>
            <div class="resend">
              <p>Code not received?</p>
              <md-button class="md-primary" @click="me = null">Resend</md-button>
            </div>
            <p class="md-caption">Test code: 0-0-0-0</p>
            <p style="color: red" v-if="invalidCode">{{ invalidCode }}</p>
            <Spinner v-if="isSubmitting" />
          </md-card-content>
        </md-card>
        <div class="break"></div>
        <div class="break"></div>
        <div class="book"></div>
      </div>
      <div v-else>
        <span class="md-display-1">What is your phone number?</span>
        <div class="break"></div>
        <div class="break"></div>
        <md-card>
          <md-card-content>
            <VuePhoneNumberInput
              v-model="form.formatted"
              default-country-code="CA"
              :no-country-selector="true"
              :required="true"
              error-color="#e42c2c"
              :no-validator-state="true"
              v-on:update="update"
              :border-radius="0"
            />
            <p class="md-caption">
              You’ll receive updates about the status of your order via this phone number.
            </p>
          </md-card-content>
        </md-card>
        <div class="break"></div>
        <div class="break"></div>
        <div class="book">
          <Spinner v-if="isSubmitting" />
          <md-button v-else @click="addPhone()" class="custom-button">Continue</md-button>
        </div>
      </div>
    </div>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axios from "axios";
import CodeInput from "vue-verification-code-input";
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
import { mapActions, mapGetters } from "vuex";
import Snackbar from "../../shared/Snackbar";
import Spinner from "../../shared/Spinner";
import localData from "../services/localData";
export default {
  name: "Movers",
  components: {
    Snackbar,
    Spinner,
    CodeInput,
    VuePhoneNumberInput,
  },
  data: () => ({
    form: {
      formatted: null,
      phone: null,
      name: "Customer",
      type: "customer",
    },

    invalidCode: null,
    isSubmitting: false,
    me: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    this.me = localData.read("me");
    this.$emit("progress", 0);
    localData.save("cr", this.$router.currentRoute.path);
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
    update(v) {
      this.form.phone = v.isValid ? v.formattedNumber : null;
    },
    addPhone() {
      if (!this.form.phone) {
        this.snackbar.statusCode = 400;
        this.snackbar.message = "Invalid phone number!";
        this.snackbar.show = true;
      } else {
        localData.save("phone", this.form);
        if (this.authenticated && this.user.role[0].name === "customer") {
          this.$router.push("/order/moving-payment");
        } else {
          this.isSubmitting = true;
          axios
            .post("auth/verify", this.form)
            .then((res) => {
              this.isSubmitting = false;
              this.me = res.data;
              localData.save("me", res.data);
              console.log("from Vonage", res.data);
            })
            .catch((err) => {
              console.log(err.response);
              this.isSubmitting = false;
              this.snackbar.statusCode = err.response.status;
              this.snackbar.message = err.response.data.phone;
              this.snackbar.show = true;
            });
          /*         this.$router.push({
          name: "signin",
          query: {
            redirect: "/order/moving-payment",
          },
        }); */
        }
      }
    },
    onChange(v) {
      console.log("onChange ", v);
    },
    verify(v) {
      this.isSubmitting = true;
      this.invalidCode = null;
      this.signIn({ code: v, me: this.me })
        .then((res) => {
          localData.remove("me");
          this.isSubmitting = false;
          this.$router.push("/order/moving-payment");
        })
        .catch((error) => {
          this.invalidCode = v + " is not valid, please check your phone!";
          console.log("err: ", error);
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
.contact {
  text-align: center;
  .md-card {
    text-align: left;
    min-width: 400px;
    padding: 20px;
    .md-button {
      margin-right: 0;
      padding: 5px;
      border-radius: 5px;
    }
  }
  .book {
    text-align: right;
    margin-right: 16px;
    min-width: 416px;
  }
}
.resend {
  display: flex;
  align-items: center;
}
@media only screen and (max-width: 600px) {
  .contact {
    text-align: center;
    .md-card {
      min-width: 300px !important;
      margin: auto;
    }
    .book {
      min-width: 300px !important;
    }
  }
}
</style>
