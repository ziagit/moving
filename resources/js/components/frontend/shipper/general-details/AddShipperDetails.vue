<template>
  <b-card class="border-0 shadow text-left" header="Add Details">
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <div>
        <b-form-group>
          <b-form-input
            type="text"
            v-model="form.first_name"
            required
            ref="focusable"
            placeholder="First name"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input
            type="text"
            v-model="form.last_name"
            required
            placeholder="Last name"
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
          :initialData="form.address"
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
import localData from "../../services/localData";
export default {
  name: "AddGeneralInfo",
  components: {
    Toaster,
    GoogleAddress3,
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
    },
    hasCompany: false,
    isSubmitting: false,
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
      console.log("form", this.form);
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
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            error.response.data.errors
          );
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
