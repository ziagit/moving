<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <md-card class="main-card">
        <div class="inputs-container">
          <div class="row">
            <md-field>
              <label for="">First name</label>
              <md-input
                type="text"
                v-model="form.first_name"
                required
                ref="focusable"
              ></md-input>
            </md-field>
            <md-field>
              <label for="">Last name</label>
              <md-input type="text" v-model="form.last_name" required></md-input>
            </md-field>
            <md-field>
              <label for="">Phone</label>
              <md-input type="tel" v-model="form.phone" required></md-input>
            </md-field>
          </div>
          <div class="row">
            <GoogleAddress3
              v-on:google-valid-address="googleValidAddress"
              v-on:google-invalid-address="googleInvalidAddress"
              :initialData="form.address"
              label="Full adddress"
            />

            <md-field>
              <label for="">Country</label>
              <md-input v-model="form.country" required disabled></md-input>
            </md-field>
            <md-field>
              <label for="">State</label>
              <md-input v-model="form.state" required disabled></md-input>
            </md-field>

            <md-field>
              <label for="">City</label>
              <md-input v-model="form.city" required disabled></md-input>
            </md-field>
            <md-field>
              <label for="">Postal code</label>
              <md-input v-model="form.zip" required disabled></md-input>
            </md-field>
          </div>
        </div>
        <Spinner v-if="isSubmitting" />
        <md-button v-if="!isSubmitting" type="submit" class="md-primary md-small-fab"
          >Save</md-button
        >
      </md-card>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
import localData from "../../services/localData";
export default {
  name: "AddGeneralInfo",
  components: {
    Snackbar,
    Spinner,
    GoogleAddress3,
  },
  data: () => ({
    form: {
      first_name: null,
      last_name: null,
      addressId: null,
      country: null,
      state: null,
      city: null,
      zip: null,
      formatted_address: null,
      phone: null,
      website: null,
      company: null,
      detail: null,
    },
    hasCompany: false,
    isSubmitting: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  mounted() {
    this.$refs.focusable.$el.focus();
  },
  methods: {
    googleValidAddress(address, latlng) {
      this.supportedArea = "";
      this.form.country = address.country;
      this.form.state = address.state;
      this.form.city = address.city;
      this.form.zip = address.zip;
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
      this.form.formatted_address = null;
    },
    submit() {
      this.isSubmitting = true;
      axios
        .post("shipper/details", this.form)
        .then((res) => {
          this.isSubmitting = false;
          if (localData.read("cr") === "/order/movers") {
            this.$router.push("/order/moving-payment");
          } else {
            this.$router.push("/shipper/profile");
          }
        })
        .catch((error) => {
          this.isSubmitting = false;
          console.log("err: ", error.response);
          this.snackbar.message = error.response.data.error;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.main-card {
  padding: 30px;
  text-align: center;
  box-shadow: none;
  border: solid 1px #ddd;

  .shipper-logo {
    text-align: center;
    margin-top: -40px;

    .md-large {
      background: #ddd;
    }
  }

  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .md-field {
      flex: 25%;
    }
  }
}
</style>
