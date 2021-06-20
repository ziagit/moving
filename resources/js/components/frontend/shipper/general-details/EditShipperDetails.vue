<template>
  <b-card class="border-0 shadow text-left" header="Edit Details">
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <div>
        <b-form-group>
          <b-form-input
            type="text"
            v-model="form.first_name"
            ref="focusable"
            placeholder="First name"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input
            type="text"
            v-model="form.last_name"
            placeholder="Last name"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input
            type="tel"
            v-model="form.phone"
            required
            placeholder="Phone"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input
            type="tel"
            v-model="form.email"
            required
            placeholder="Email"
          ></b-form-input>
        </b-form-group>
        <GoogleAddress3
          v-on:google-valid-address="googleValidAddress"
          v-on:google-invalid-address="googleInvalidAddress"
          :initialData="form.formatted_address"
          label="Full adddress"
        />
        <div class="text-right">
          <b-spinner variant="primary" v-if="isSubmitting" />
          <b-button v-else type="submit" variant="primary" class="mt-3">Save</b-button>
        </div>
      </div>
    </form>
    <Toaster ref="toaster" />
  </b-card>
</template>

<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Toaster from "../../../shared/Toaster";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "EditGeneralInfo",
  components: {
    GoogleAddress3,
    Toaster,
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
    },
    isSubmitting: false,
    snackbar: {},
  }),
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
        .put("shipper/details/" + this.$route.params.id, this.form)
        .then((res) => {
          this.isSubmitting = false;
          this.$router.push("/shipper/profile");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.isSubmitting = false;
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            error.response.data.errors
          );
        });
    },
    init() {
      axios.get("shipper/details/" + this.$route.params.id).then(
        (res) => {
          console.log("shipper o ted", res.data);
          this.form.first_name = res.data.first_name;
          this.form.last_name = res.data.last_name;
          this.form.email = res.data.user.email;
          this.form.phone = res.data.user.phone;
          this.form.addressId = res.data.address.id;
          this.form.country = res.data.address.country;
          this.form.state = res.data.address.state;
          this.form.city = res.data.address.city;
          this.form.zip = res.data.address.zip;
          this.form.formatted_address = res.data.address.formatted_address;
        },
        (err) => {
          console.log(err);
        }
      );
    },
  },
  created() {
    this.init();
  },
};
</script>

<style lang="scss" scoped></style>
