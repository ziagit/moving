<template>
  <div>
    <b-form-group>
      <b-form-input
        v-model="list.formatted_address"
        required
        id="autocomplete3"
        placeholder="Address"
      ></b-form-input>
    </b-form-group>
  </div>
</template>
<script>
export default {
  props: ["initialData", "label"],
  data: () => ({
    supportedArea: "",
    supportTogal: false,
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
    if (this.initialData != null) {
      this.list.formatted_address = this.initialData;
    }
  },
  mounted() {
    let $vm = this;
    var autocomplete3 = new google.maps.places.Autocomplete(
      document.getElementById("autocomplete3"),
      {
        //types: ["address"],
        componentRestrictions: { country: "ca" },
        bounds: new google.maps.LatLngBounds(
          new google.maps.LatLng(49.246292, -123.116226)
        ),
        //strictbounds: true,
      }
    );

    google.maps.event.addListener(autocomplete3, "place_changed", function () {
      var data = autocomplete3.getPlace();

      let latlng = {
        lat: data.geometry.location.lat(),
        lng: data.geometry.location.lng(),
      };
      data.address_components.forEach((component) => {
        console.log("component from google", component);
        if (component.types.indexOf("administrative_area_level_1") > -1) {
          if (component.short_name != "BC") {
            $vm.invalidAddress(data);
          } else {
            $vm.validAddress(data, latlng);
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
      let components = data.address_components;
      let $vm = this;
      $vm.list.formatted_address = data.formatted_address;
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
          $vm.list.state = component.long_name;
        }
        if (types.indexOf("postal_code") > -1) {
          $vm.list.zip = component.long_name;
        }
        if (types.indexOf("country") > -1) {
          $vm.list.country = component.long_name;
        }
      });
      $vm.list.isValid = false;
      this.$emit("google-invalid-address", $vm.list);
    },
  },
};
</script>

<style lang="scss" scoped></style>
