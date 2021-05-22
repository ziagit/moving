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
import localData from "../services/localData";
import GoogleAddress2 from "../../shared/GoogleAddress2.vue";
export default {
  name: "To",
  data: () => ({
    supportedArea: null,
    initialData: null,
    locations: null,
    to: {
      country: "",
      state: "",
      city: "",
      zip: "",
      street: "",
      street_number: "",
      formatted_address: "",
      type: "",
    },
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    async nextStep(type) {
      if (
        this.to.country === "" ||
        this.to.state === "" ||
        this.to.city === "" ||
        this.to.zip === ""
      ) {
        this.snackbar.show = true;
        this.snackbar.message = "Please provide a valid address!";
        this.snackbar.statusCode = 404;
      } else {
        this.to.type = type;
        localData.save("to", this.to);
        if (type.code == "apartment") {
          this.$router.push("to-state");
        } else {
          await localData.remove("to-state");
          if (localData.read("type") == "office") {
            this.$router.push("office-sizes");
          } else {
            this.$router.push("moving-sizes");
          }
        }
      }
    },
    back() {
      if (localData.read("from-state")) {
        this.$router.push("from-state");
      } else {
        this.$router.push("from");
      }
    },
    googleValidAddress(address, latlng) {
      console.log("inside to");
      this.supportedArea = "";
      this.to.country = address.country;
      this.to.state = address.state;
      this.to.city = address.city;
      this.to.zip = address.zip;
      this.to.street = address.street;
      this.to.street_number = address.street_number;
      this.to.formatted_address = address.formatted_address;
      //this.$emit("destinationChanged", address.formatted_address, latlng);
    },
    googleInvalidAddress(address) {
      this.supportedArea = address.state;
      this.to.country = null;
      this.to.state = null;
      this.to.city = null;
      this.to.zip = null;
      this.to.street = null;
      this.to.street_number = null;
      this.to.formatted_address = null;
    },
    async init() {
      let local = localData.read("to");
      if (local) {
        this.initialData = local;
        this.to.country = local.country;
        this.to.state = local.state;
        this.to.city = local.city;
        this.to.zip = local.zip;
        this.to.street = local.street;
        this.to.street_number = local.street_number;
        this.to.formatted_address = local.formatted_address;
      }
    },

    progress() {
      if (localData.read("from-state")) {
        this.$emit("progress", 1);
      } else {
        this.$emit("progress", 2);
      }
    },
  },
  created() {
    this.progress();
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
