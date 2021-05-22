<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <div class="carrier-details">
        <div class="row">
          <GoogleAddress3
            v-on:google-valid-address="googleValidAddress"
            v-on:google-invalid-address="googleInvalidAddress"
            :initialData="form.address"
            label="Full address"
          />
          <md-field>
            <label>Country</label>
            <md-input v-model="form.country"></md-input>
          </md-field>
          <md-field>
            <label>State</label>
            <md-input v-model="form.state"></md-input>
          </md-field>
        </div>
        <div class="row">
          <md-field>
            <label>City</label>
            <md-input v-model="form.city"></md-input>
          </md-field>
          <md-field>
            <label>Zip</label>
            <md-input v-model="form.zip"></md-input>
          </md-field>
        </div>
      </div>

      <md-button type="submit" class="md-primary md-small-fab">Done</md-button>
    </form>
  </div>
</template>

<script>
import GoogleAddress3 from "../../shared/GoogleAddress3";
import axios from "axios";
export default {
  name: "Edit",
  props: ["address"],
  components: {
    GoogleAddress3,
  },
  data: () => ({
    form: {
      country: null,
      state: null,
      city: null,
      address: null,
      zip: null,
      street: null,
      street_number: null,
    },
    supportedArea: null,
    countries: null,
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
      this.form.address = address.formatted_address;
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
      axios
        .put("admin/addresses/" + this.address.id, this.form)
        .then((res) => {
          console.log("response ", res.data);
          this.$emit("close-dialog");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
        });
    },
    init() {
      console.log(this.address);
      this.form.country = this.address.country;
      this.form.state = this.address.state;
      this.form.city = this.address.city;
      this.form.address = this.address.formatted_address;
      this.form.zip = this.address.zip;
      this.form.street = this.address.street;
      this.form.street_number = this.address.street_number;
    },
    getCountries() {
      axios
        .get("countries")
        .then((res) => {
          this.countries = res.data;
          this.init();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    tapHandler(direction) {
      console.log("tap: ", direction);
    },
  },
  created() {
    this.getCountries();
  },
};
</script>

<style lang="scss" scoped>
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

.md-menu-content-bottom-start,
.md-menu-content-small,
.md-menu-content {
  z-index: 100;
  /*     position: absolute;
    top: 364px !important; */
}
.md-button {
  float: right !important;
}
</style>
