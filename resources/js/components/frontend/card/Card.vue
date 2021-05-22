<template>
  <div class="card">
    <form
      @submit.prevent="getStripeToken"
      id="payment-form"
      enctype="multipart/form-data"
    >
      <span class="md-display-1" v-if="!togal">Payment Information</span>
      <span class="md-body-2" v-if="togal">Card Information</span>
      <div v-if="authenticated && user.role[0].name === 'customer'">
        <md-checkbox
          class="md-primary"
          :class="{ shipperTogal: togal }"
          v-model="sameAddress"
        >
          Is your billing address same to your profile address ?
          <md-icon class="md-primary">
            info
            <md-tooltip>You wounldn't notified in case of different email!</md-tooltip>
          </md-icon>
        </md-checkbox>
      </div>
      <div class="row">
        <md-field>
          <label>Name</label>
          <md-input type="text" v-model="form.name" required ref="focusable"></md-input>
        </md-field>
        <md-field v-if="togal">
          <label>Email</label>
          <md-input type="email" v-model="form.email" required></md-input>
        </md-field>
      </div>
      <div class="row">
        <md-field v-if="!togal">
          <label>Email</label>
          <md-input type="email" v-model="form.email" required></md-input>
        </md-field>
        <md-field v-if="!togal">
          <label>Phone</label>
          <md-input type="number" v-model="form.phone" required></md-input>
        </md-field>
      </div>

      <GoogleAddress3
        v-on:google-valid-address="googleValidAddress"
        v-on:google-invalid-address="googleInvalidAddress"
        :initialData="form.formatted_address"
        label="Adddress"
      />
      <div class="row">
        <md-field>
          <label>Country</label>
          <md-input type="text" v-model="form.country" required disabled></md-input>
        </md-field>

        <md-field>
          <label>State</label>
          <md-input type="text" v-model="form.state" required disabled></md-input>
        </md-field>
      </div>
      <div class="row">
        <md-field>
          <label>City</label>
          <md-input type="text" v-model="form.city" required disabled></md-input>
        </md-field>

        <md-field>
          <label>Postal code</label>
          <md-input type="text" v-model="form.postalcode" required disabled></md-input>
        </md-field>
      </div>
      <md-field>
        <label>Name on card</label>
        <md-input type="text" v-model="form.name_oncard" required></md-input>
      </md-field>
      <div ref="card">
        <!-- A Stripe Element will be inserted here. -->
      </div>

      <!-- Used to display form togals. -->
      <div class="break"></div>
      <div class="break"></div>
      <div class="action">
        <md-button
          v-if="!isSubmitting"
          id="submit-button"
          class="custom-button"
          type="submit"
          >Pay</md-button
        >
      </div>
      <Spinner v-if="isSubmitting" />
      <div v-if="cardAdded">
        <div>Your payment is processing...</div>
      </div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import GoogleAddress3 from "../../shared/GoogleAddress3";
import axios from "axios";
import Snackbar from "../../shared/Snackbar";
import Spinner from "../../shared/Spinner";
import { mapGetters } from "vuex";
import localData from "../services/localData";
import functions from "../services/functions";
var stripe = Stripe(process.env.MIX_STRIPE_KEY);
var style = {
  base: {
    color: "#32325d",
    fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#aab7c4",
    },
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a",
  },
};
var card = undefined;
export default {
  name: "Card",
  components: {
    Spinner,
    Snackbar,
    GoogleAddress3,
  },
  data: () => ({
    elements: stripe.elements(),
    form: {
      name: null,
      email: null,
      phone: null,
      country: null,
      formatted_address: null,
      city: null,
      state: null,
      postalcode: null,
      name_oncard: null,
      stripeToken: null,
      price: null,
    },
    sameAddress: false,
    shipperExist: null,
    isSubmitting: false,
    cardAdded: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
    togal: false,
  }),
  created() {
    localData.save("cr", this.$router.currentRoute.path);
    this.$router.currentRoute.path == "/shipper/card"
      ? (this.togal = true)
      : (this.togal = false);
  },
  mounted: function () {
    card = this.elements.create("card", {
      style: style,
      hidePostalCode: true,
    });
    card.mount(this.$refs.card);
    this.$refs.focusable.$el.focus();
  },
  watch: {
    sameAddress: function (value) {
      if (value) {
        if (this.shipperExist === null) {
          axios
            .get("shipper/shipper-address")
            .then((res) => {
              this.form.name = res.data.name;
              this.form.formatted_address =
                res.data.shipper_with_address.address.formatted_address;
              this.form.country = res.data.shipper_with_address.address.country;
              this.form.state = res.data.shipper_with_address.address.state;
              this.form.city = res.data.shipper_with_address.address.city;
              this.form.postalcode = res.data.shipper_with_address.address.zip;
              this.form.phone = res.data.shipper_with_address.contact.phone;
              this.form.email = res.data.shipper_with_address.contact.email;
              this.shipperExist = res.data;
            })
            .catch((err) => console.log(err));
        } else {
          this.form.name = this.shipperExist.name;
          this.form.formatted_address = this.shipperExist.shipper_with_address.address.formatted_address;
          this.form.country = this.shipperExist.shipper_with_address.address.country;
          this.form.state = this.shipperExist.shipper_with_address.address.state;
          this.form.city = this.shipperExist.shipper_with_address.address.city;
          this.form.postalcode = this.shipperExist.shipper_with_address.address.zip;
          this.form.phone = this.shipperExist.shipper_with_address.contact.phone;
          this.form.email = this.shipperExist.shipper_with_address.contact.email;
        }
      } else {
        this.form.name = this.form.phone = this.form.email = this.form.formatted_address = this.form.state = this.form.city = this.form.postalcode = this.form.country = null;
      }
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },

  methods: {
    googleValidAddress(address, latlng) {
      this.supportedArea = "";
      this.form.country = address.country;
      this.form.state = address.state;
      this.form.city = address.city;
      this.form.postalcode = address.zip;
      this.form.street = address.street;
      this.form.street_number = address.street_number;
      this.form.formatted_address = address.formatted_address;
    },
    googleInvalidAddress(address) {
      this.supportedArea = address.state;
      this.form.country = null;
      this.form.state = null;
      this.form.city = null;
      this.form.zip = null;
      this.form.street = null;
      this.form.street_number = null;
      this.form.address = null;
    },
    getStripeToken: function () {
      if (
        this.form.name == null ||
        this.form.phone == null ||
        this.form.email == null ||
        this.form.name_oncard == null ||
        this.form.formatted_address == null ||
        this.form.country == null ||
        this.form.state == null ||
        this.form.city == null ||
        this.form.postalcode == null ||
        !functions.phoneValidator(this.form.phone) ||
        !functions.emailValidator(this.form.email)
      ) {
        this.snackbar.message = "Invalide provided information!";
        this.snackbar.statusCode = "400";
        this.snackbar.show = true;
      } else {
        this.isSubmitting = true;
        localData.save("contacts", this.form);
        stripe.createToken(card).then((result) => {
          if (result.error) {
            this.isSubmitting = false;
            this.snackbar.message = result.error.message;
            this.snackbar.statusCode = "400";
            this.snackbar.show = true;
          } else {
            this.handleStripeToken(result.token);
          }
        });
      }
    },
    handleStripeToken: function (token) {
      let carrier = localData.read("carrier");
      if (carrier) {
        this.form.price = carrier.price;
      }
      this.form.stripeToken = token.id;
      axios
        .post("charge", this.form)
        .then((res) => {
          if (this.$route.path == "/shipper/card") {
            this.$emit("close-dialog", res.data);
          } else {
            localData.save("bl", res.data);
            if (this.authenticated && this.user.role[0].name == "customer") {
              this.chargeCustomer();
            } else {
              this.$router.push("/confirmation");
            }
          }
        })
        .catch((err) => {
          this.isSubmitting = false;
          this.snackbar.show = true;
          this.snackbar.message = err.response.data.message;
          this.snackbar.statusCode = err.response.status;
          this.togalMassage = err;
        });
    },
    chargeCustomer() {
      this.cardAdded = true;
      let carrier = localData.read("carrier");
      axios
        .post("charge-customer", {
          price: carrier.price,
        })
        .then((res) => {
          var bl = {};
          bl["id"] = res.data["id"];
          bl["status"] = res.data["status"];
          bl["email"] = this.form.email;
          localData.save("bl", bl);
          this.isSubmitting = false;
          this.cardAdded = false;
          this.$router.push("/confirmation");
        })
        .catch((err) => (this.errorMassage = err));
    },
  },
};
</script>

<style lang="scss" scoped>
.shipperTogal {
  margin: 8px 16px 8px 0;
  label {
    font-size: 11px;
  }
}
.card {
  margin: auto;
  text-align: center;

  .md-display-1 {
    font-size: 24px;
  }

  .row {
    display: flex;
    justify-content: space-between;
    .md-field {
      flex: 10%;
      label {
        font-size: 14px;
      }
    }
  }
  .action {
    text-align: right;
  }
}

/**
 * The CSS shown here will not be introduced in the Quickstart guide, but shows
 * how you can use CSS to style your Element's container.
 */
.StripeElement {
  box-sizing: border-box;
  font-family: "Roboto";
  height: 40px;

  padding: 10px 12px;

  border-bottom: 1px solid #ddd;
  /* border-radius: 4px; */
  background-color: white;

  /* box-shadow: 0 1px 3px 0 #e6ebf1; */
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

/*  .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        } */

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}

@media only screen and (min-width: 600px) {
  .card {
    .header {
      margin: 10px auto;

      .md-display-1 {
        font-size: 30px;
      }
    }

    .md-card {
      padding: 0px 20px 0 20px;
    }
  }
}
</style>
