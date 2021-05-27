<template>
  <div>
    <md-card>
      <form @submit.prevent="update" enctype="multipart/form-data">
        <md-card-header>
          <span class="md-title">Edit Account Details</span>
          <md-button @click="$router.back()" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
            <md-tooltip>Cancel</md-tooltip>
          </md-button>
        </md-card-header>

        <md-card-content>
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
              <label for="">Email</label>
              <md-input type="tel" v-model="form.email" required></md-input>
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
          </div>
        </md-card-content>
        <md-card-actions>
          <Spinner v-if="isSubmitting" />
          <md-button v-else type="submit" class="md-primary">Update</md-button>
        </md-card-actions>
      </form>
    </md-card>
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
      email: null,
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
          this.form.email = res.data.contact.email;
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
.md-card {
  text-align: left;
  padding: 20px;
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
  .md-card-actions {
    text-align: right;
    display: flex;
    justify-content: flex-start;
  }
}
</style>
