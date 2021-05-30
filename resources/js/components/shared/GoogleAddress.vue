<template>
  <div class="container">
    <md-dialog-alert
      :md-active.sync="popupTogal"
      md-title="Invalid Address"
      :md-content="popupData"
    />
    <input
      v-model="list.formatted_address"
      required
      id="autocomplete"
      placeholder=""
      ref="focusable"
    />
  </div>
</template>
<script>
import validator from "../frontend/services/validator";
export default {
  props: ["initialData", "label"],
  data: () => ({
    supportedData: "",
    supportTogal: false,
    popupTogal: false,
    popupData: null,
    list: {
      country: "",
      state: "",
      city: "",
      zip: "",
      street: "",
      street_number: "",
      formatted_address: "",
    },
  }),
  watch: {
    initialData(value) {
      if (value != null) {
        this.list.formatted_address = value;
      }
    },
  },
  created() {
    this.cities();
    if (this.initialData != null) {
      this.list.formatted_address = this.initialData;
    }
  },
  mounted() {
    this.$refs.focusable.focus();
    let $vm = this;
    var autocomplete = new google.maps.places.Autocomplete(
      document.getElementById("autocomplete"),
      {
        //types: ["address"],
        componentRestrictions: { country: "ca" },
        bounds: new google.maps.LatLngBounds(
          new google.maps.LatLng(49.246292, -123.116226)
        ),
        //strictbounds: true,
      }
    );

    google.maps.event.addListener(autocomplete, "place_changed", function () {
      var data = autocomplete.getPlace();
      let latlng = {
        lat: data.geometry.location.lat(),
        lng: data.geometry.location.lng(),
      };
      data.address_components.forEach((component) => {
        if (component.types.indexOf("administrative_area_level_1") > -1) {
          if ($vm.checkState(component.short_name)) {
            $vm.validAddress(data, latlng);
          } else {
            $vm.invalidAddress(data);
          }
        }
      });
    });
  },
  methods: {
    validAddress(data, latlng) {
      let components = data.address_components;
      let $vm = this;
      $vm.list.formatted_address = data.formatted_address;
      $vm.supportedArea = "";
      components.forEach(function (component) {
        let types = component.types;
        if (types.indexOf("street_number") > -1) {
          $vm.list.street_number = component.long_name;
        }
        if (types.indexOf("route") > -1) {
          $vm.list.street = component.long_name;
        }
        if (types.indexOf("locality") > -1) {
          $vm.list.city = component.long_name;
        }
        if (types.indexOf("administrative_area_level_1") > -1) {
          $vm.list.state = component.short_name;
        }
        if (types.indexOf("postal_code") > -1) {
          $vm.list.zip = component.long_name;
        }
        if (types.indexOf("country") > -1) {
          $vm.list.country = component.long_name;
        }
      });
      this.$emit("google-valid-address", $vm.list, latlng);
    },
    invalidAddress(data) {
      console.log("invalid data: ", data);
      this.popupTogal = true;
      this.popupData = `The destination is out of our current service area. We are working on expanding our <a href="https://tingsapp.com/cities">coverage</a>`;
    },
    checkState(selected) {
      for (let i = 0; i < this.supportedData.length; i++) {
        if (this.supportedData[i].name == selected) {
          return true;
        }
      }
      return false;
    },
    checkCity(selected) {
      for (let i = 0; i < this.supportedData.length; i++) {
        for (let j = i; j < this.supportedData[i].cities.length; j++) {
          if (this.supportedData[i].cities[j].name == selected) {
            return true;
          }
        }
      }
      return false;
    },
    cities() {
      axios
        .get("state-cities")
        .then((res) => {
          this.supportedData = res.data;
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  width: 100%;
  input {
    width: 300px;
    border: none;
    font-size: unset !important;
    color: unset !important;
  }
  input:focus {
    outline: none;
  }
}
</style>
