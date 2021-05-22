<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card class="main-card">
        <md-button @click="$router.back()" class="md-icon-button add-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <div class="shipper-details">
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
              v-if="form.formatted_address != null"
              v-on:google-valid-address="googleValidAddress"
              v-on:google-invalid-address="googleInvalidAddress"
              :initialData="form.formatted_address"
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
          >Done</md-button
        >
      </md-card>
    </form>
  </div>
</template>

<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
export default {
  name: "EditGeneralInfo",
  components: {
    GoogleAddress3,
    Snackbar,
    Spinner,
  },
  data: () => ({
    form: {
      first_name: null,
      last_name: null,
      country: null,
      state: null,
      city: null,
      zip: null,
      formatted_address: null,
      phone: null,
      addressId: null,
      contactId: null,
    },
    isSubmitting: false,
    hasCompany: false,
  }),

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
    update() {
      this.isSubmitting = true;
      axios
        .put("shipper/details/" + this.$route.params.id, this.form)
        .then((res) => {
          this.isSubmitting = false;
          this.$router.push("/shipper/profile");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.isSubmitting = false;
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },
    init() {
      axios.get("shipper/details/" + this.$route.params.id).then(
        (res) => {
          console.log("shipper o ted", res.data);
          this.form.first_name = res.data.first_name;
          this.form.last_name = res.data.last_name;
          this.form.phone = res.data.contact.phone;
          this.form.website = res.data.website;
          this.form.company = res.data.company;
          this.form.detail = res.data.detail;
          this.form.contactId = res.data.contact.id;
          this.form.addressId = res.data.address.id;
          this.form.country = res.data.address.country;
          this.form.state = res.data.address.state;
          this.form.city = res.data.address.city;
          this.form.zip = res.data.address.zip;
          this.form.formatted_address = res.data.address.formatted_address;
          this.oldLogo = res.data.logo;
        },
        (err) => {
          console.log(err);
        }
      );
    },
  },
  computed: {},
  created() {
    this.init();
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

    .select-logo {
      position: absolute;
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

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }

  .zip-address {
    flex: 50%;
  }
}
</style>
