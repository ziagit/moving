<template>
  <form>
    <GoogleAddress2
      v-on:google-valid-address="googleValidAddress"
      v-on:google-invalid-address="googleInvalidAddress"
      :initialData="initialData"
    />
  </form>
</template>

<script>
import GoogleAddress2 from "../../shared/GoogleAddress2";
import localData from "../services/localData";
export default {
  name: "Origin",
  data: () => ({
    supportedArea: null,
    initialData: null,
    locations: null,
    from: {
      country: "",
      state: "",
      city: "",
      zip: "",
      street: "",
      street_number: "",
      formatted_address: "",
    },
  }),

  methods: {
    googleValidAddress(address, latlng) {
      console.log("inside from");
      this.supportedArea = "";
      this.from.country = address.country;
      this.from.state = address.state;
      this.from.city = address.city;
      this.from.zip = address.zip;
      this.from.street = address.street;
      this.from.street_number = address.street_number;
      this.from.formatted_address = address.formatted_address;
      //this.$emit("originChanged", address.formatted_address, latlng);
    },
    googleInvalidAddress(address) {
      this.supportedArea = address.state;
      this.from.country = null;
      this.from.state = null;
      this.from.city = null;
      this.from.zip = null;
      this.from.street = null;
      this.from.street_number = null;
      this.from.formatted_address = null;
      console.log("invalid add", address);
    },
    init() {
      let local = localData.read("from");
      if (local) {
        this.initialData = local;
        this.from.country = local.country;
        this.from.state = local.state;
        this.from.city = local.city;
        this.from.zip = local.zip;
        this.from.street = local.street;
        this.from.street_number = local.street_number;
        this.from.formatted_address = local.formatted_address;
      }
    },
  },
  created() {
    this.$emit("progress", 0);
    this.init();
  },
  components: {
    GoogleAddress2,
  },
};
</script>

<style lang="scss" scoped>
form {
  position: relative;
  img {
    position: absolute;
    margin: 23px;
    height: 93px;
  }

  .md-button {
    margin-right: 16px;
    width: 185px;
    .md-button-content {
      font-size: 16px !important;
    }
  }
}
</style>
