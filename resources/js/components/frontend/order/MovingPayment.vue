<template>
  <div class="container">
    <div v-if="checkingCard">
      <div v-if="charging">Payment in process...</div>
      <div v-else>Checking card...</div>
      <div>
        <Spinner />
      </div>
    </div>
    <div v-else>
      <Card v-if="addCard" />
      <form
        v-else
        @submit.prevent="confirm"
        id="payment-form"
        enctype="multipart/form-data"
      >
        <span class="md-display-1">Contact Details</span>
        <div style="color: green" v-if="paymentStatus">{{ paymentStatus }}</div>
        <div v-if="authenticated && user.role[0].name === 'customer'">
          <md-checkbox class="md-primary" v-model="sameAddress">
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
        </div>
        <div class="row">
          <md-field>
            <label>Email</label>
            <md-input type="email" v-model="form.email" required></md-input>
          </md-field>
          <md-field>
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

        <!-- Used to display form togals. -->
        <div class="break"></div>
        <div class="break"></div>
        <div class="action">
          <md-button
            v-if="!isSubmitting"
            id="submit-button"
            class="custom-button"
            type="submit"
            >Confirm</md-button
          >
        </div>
      </form>
    </div>

    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import localData from "../services/localData";
import GoogleAddress3 from "../../shared/GoogleAddress3";
import functions from "../services/functions";
import Card from "../card/Card";
export default {
  name: "MovingPayment",
  components: {
    Spinner,
    Snackbar,
    GoogleAddress3,
    Card,
  },
  data: () => ({
    checkingCard: false,
    charging: false,
    addCard: false,
    sameAddress: false,
    shipperExist: null,
    isSubmitting: false,
    paymentStatus: null,
    form: {
      name: null,
      email: null,
      phone: null,
      country: null,
      formatted_address: null,
      city: null,
      state: null,
      postalcode: null,
    },
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    this.getCard();
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
              this.form.email = res.data.email;
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
          this.form.email = this.shipperExist.email;
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
    getCard() {
      this.checkingCard = true;
      axios
        .get("shipper/card-details")
        .then((res) => {
          if (res.data) {
            this.charging = true;
            console.log("card exist", res.data);
            this.checkPayment();
          } else {
            this.checkingCard = false;
            console.log("card not exist", res.data);
            this.addCard = true;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    checkPayment() {
      let billing = localData.read("bl");
      if (billing && billing.status && billing.id != null) {
        axios
          .get("check-payment/" + billing.id)
          .then((res) => {
            this.paymentStatus = res.data.message;
            this.checkingCard = false;
            console.log(res.data);
          })
          .catch((err) => console.log(err));
      } else {
        this.chargeCustomer();
      }
    },
    chargeCustomer() {
      let carrier = localData.read("carrier");
      axios
        .post("charge-customer", {
          price: carrier.price,
        })
        .then((res) => {
          console.log("response", res.data);
          localData.save("bl", res.data);
          this.paymentStatus = res.data.message;
          this.checkingCard = false;
        })
        .catch((err) => (this.errorMassage = err));
    },
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
    confirm() {
      if (
        this.form.name == null ||
        this.form.phone == null ||
        this.form.email == null ||
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
        localData.save("contacts", this.form);
        this.$router.push("/confirmation");
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  margin: auto;
  text-align: center;

  .md-display-1 {
    font-size: 24px;
  }

  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
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
</style>
