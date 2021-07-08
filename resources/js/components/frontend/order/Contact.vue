<template>
  <div class="origin">
    <div>
      <div v-if="me">
        <h3>Enter verification code</h3>
        <div class="break"></div>
        <div class="break"></div>
        <b-card class="border-0 shadow my-card">
          <CodeInput
            :loading="false"
            class="input"
            :fields="4"
            :fieldWidth="60"
            v-on:change="onChange"
            v-on:complete="verify"
          />
          <p class="blockquote-footer text-left">
            We texted a code to your phone number.
          </p>
          <div class="resend">
            <p class="mb-0">Code not received?</p>
            <b-link class="ml-3" @click="me = null">Resend</b-link>
          </div>
          <p style="color: red" v-if="invalidCode">{{ invalidCode }}</p>
          <b-spinner variant="primary" v-if="isSubmitting" />
        </b-card>
        <div class="break"></div>
        <div class="break"></div>
        <div class="book"></div>
      </div>
      <div v-else>
        <h3>What is your phone number?</h3>
        <div class="break"></div>
        <div class="break"></div>
        <b-card class="shadow border-0">
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
          <p class="blockquote-footer text-left">
            You’ll receive updates about the status of your order via this phone number.
          </p>
          <div class="break"></div>
          <div class="book">
            <b-spinner variant="primary" v-if="isSubmitting" />
            <b-button v-else @click="addPhone()" variant="primary">Continue</b-button>
          </div>
        </b-card>
      </div>
    </div>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import axios from "axios";
import CodeInput from "vue-verification-code-input";
import VuePhoneNumberInput from "vue-phone-number-input";
import "vue-phone-number-input/dist/vue-phone-number-input.css";
import { mapActions, mapGetters } from "vuex";
import Toaster from "../../shared/Toaster";
import localData from "../services/localData";
export default {
  name: "Movers",
  components: {
    Toaster,
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
        this.$refs.toaster.show(
          "danger",
          "b-toaster-top-center",
          "Invalid",
          "Provide a valid phone!"
        );
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
              this.$refs.toaster.show(
                "danger",
                "b-toaster-top-center",
                "Error",
                err.response.data.phone
              );
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
.origin {
  width: 100%;
  text-align: center;
  .my-card {
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
