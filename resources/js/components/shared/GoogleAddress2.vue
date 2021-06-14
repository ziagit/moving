<template>
  <div class="google-address2">
    <md-dialog-alert
      :md-active.sync="popupTogal"
      md-title="Invalid Address"
      :md-content="popupData"
    />
    <form @submit.prevent="getQuote()" method="post" name="theform" id="theform">
      <img :src="'/images/uploads/a-b.svg'" width="12" alt="" />
      <div>
        <input
          type="text"
          v-model="form.from.formatted_address"
          required
          id="autocomplete1"
          placeholder="Enter pickup location"
        />
        <span class="near-me" id="currentLocation" @click="getLocation()"
          ><md-icon>near_me</md-icon></span
        >
      </div>

      <div>
        <input
          type="text"
          v-model="form.to.formatted_address"
          name="DropoffLocation"
          placeholder="Enter dropoff location"
          id="autocomplete2"
          required
        />
        <md-menu md-direction="top-start" :md-active.sync="infoTogal">
          <md-icon md-menu-trigger>info_outline</md-icon>
          <md-menu-content>
            <div style="padding: 10px">
              - Please select pickup location and <br />
              destination in the same city or metro <br />
              area, within our
              <a href="https://tingsapp.com/cities" target="_blank">coverage</a>.
              <div class="break"></div>
              - For junk removal, please search a <br />
              <a
                href="https://www.google.com/search?q=disposal+area+near+me&sxsrf=ALeKk01Dmb-Q2xWE4XdTkgQnGnW3j98yog%3A1621308734570&source=hp&ei=PjWjYO6nIOWmrgT_n4zICg&iflsig=AINFCbYAAAAAYKNDTiFu5JE7M2WPkrz60o6SYW8uj_dB&oq=disposal+area+near&gs_lcp=Cgdnd3Mtd2l6EAMYADIFCAAQyQMyBggAEBYQHjIGCAAQFhAeOgQIIxAnOgIIADoCCC46BAgAEEM6CQgjECcQRhD5AToKCC4QxwEQrwEQQzoKCAAQyQMQQxCLAzoHCAAQQxCLAzoECAAQClDqlhRYis0UYPTcFGgAcAB4AYABlwSIAdQnkgELMC41LjguMi4xLjKYAQCgAQGqAQdnd3Mtd2l6uAEC&sclient=gws-wiz&dlnr=1&sei=kzajYJRHg-CSBc6Aj7gO"
                target="_blank"
                >disposal site near you</a
              >. Paste their <br />
              address in destination
            </div>
          </md-menu-content>
        </md-menu>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div>
        <md-button class="custom-button" type="submit">Get a Price</md-button>
      </div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>
<script>
import Popup from "./AddressValidatePopup";
import Snackbar from "./Snackbar";
import localData from "../frontend/services/localData";
export default {
  props: ["initialData"],
  data: () => ({
    isSupportedFrom: false,
    isSupportedTo: false,
    supportedData: null,
    sameCity: null,
    infoTogal: false,
    popupTogal: false,
    popupData: null,
    form: {
      from: {
        country: "",
        state: "",
        city: "",
        zip: "",
        street: "",
        street_number: "",
        formatted_address: "",
        latlng: "",
      },
      to: {
        country: "",
        state: "",
        city: "",
        zip: "",
        street: "",
        street_number: "",
        formatted_address: "",
        latlng: "",
      },
    },
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  components: {
    Snackbar,
    Popup,
  },
  created() {
    this.cities();
    this.init();
  },
  mounted() {
    let $vm = this;
    // this.$refs.focusable.$el.focus();
    var autocomplete1 = new google.maps.places.Autocomplete(
      document.getElementById("autocomplete1"),
      {
        //types: ["address"],
        componentRestrictions: { country: "ca" },
        bounds: new google.maps.LatLngBounds(
          new google.maps.LatLng(49.246292, -123.116226)
        ),
        //strictbounds: true,
      }
    );
    google.maps.event.addListener(autocomplete1, "place_changed", function () {
      var data = autocomplete1.getPlace();
      let latlng = {
        lat: data.geometry.location.lat(),
        lng: data.geometry.location.lng(),
      };
      $vm.form.from.latlng = latlng;
      $vm.fromAddress(data);
    });
    var autocomplete2 = new google.maps.places.Autocomplete(
      document.getElementById("autocomplete2"),
      {
        //types: ["address"],
        componentRestrictions: { country: "ca" },
        bounds: new google.maps.LatLngBounds(
          new google.maps.LatLng(49.246292, -123.116226)
        ),
        //strictbounds: true,
      }
    );
    google.maps.event.addListener(autocomplete2, "place_changed", function () {
      var data = autocomplete2.getPlace();
      let latlng = {
        lat: data.geometry.location.lat(),
        lng: data.geometry.location.lng(),
      };
      $vm.form.to.latlng = latlng;
      $vm.toAddress(data);
    });
  },
  methods: {
    fromAddress(data) {
      let components = data.address_components;
      let $vm = this;
      $vm.form.from.formatted_address = data.formatted_address;
      components.forEach(function (component) {
        let types = component.types;
        if (types.indexOf("street_number") > -1) {
          $vm.form.from.street_number = component.long_name;
        }
        if (types.indexOf("route") > -1) {
          $vm.form.from.street = component.long_name;
        }
        if (types.indexOf("locality") > -1) {
          $vm.form.from.city = component.long_name;
        }
        if (types.indexOf("administrative_area_level_1") > -1) {
          $vm.form.from.state = component.short_name;
        }
        if (types.indexOf("postal_code") > -1) {
          $vm.form.from.zip = component.long_name;
        }
        if (types.indexOf("country") > -1) {
          $vm.form.from.country = component.long_name;
        }
      });
      localData.save("from", $vm.form.from);
      //this.$emit("from-valid-address", $vm.form.from, latlng);
    },

    toAddress(data) {
      let components = data.address_components;
      let $vm = this;
      $vm.form.to.formatted_address = data.formatted_address;
      components.forEach(function (component) {
        let types = component.types;
        if (types.indexOf("street_number") > -1) {
          $vm.form.to.street_number = component.long_name;
        }
        if (types.indexOf("route") > -1) {
          $vm.form.to.street = component.long_name;
        }
        if (types.indexOf("locality") > -1) {
          $vm.form.to.city = component.long_name;
        }
        if (types.indexOf("administrative_area_level_1") > -1) {
          $vm.form.to.state = component.short_name;
        }
        if (types.indexOf("postal_code") > -1) {
          $vm.form.to.zip = component.long_name;
        }
        if (types.indexOf("country") > -1) {
          $vm.form.to.country = component.long_name;
        }
      });
      localData.save("to", $vm.form.to);
      //this.$emit("to-valid-address", $vm.form.to, latlng);
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

    getQuote() {
      if (this.form.from.formatted_address == this.form.to.formatted_address) {
        this.popupTogal = true;
        this.popupData = "Pickup and destination addresses shouldn't be the same!";
      } else if (
        this.form.from.country == "" ||
        this.form.from.state == "" ||
        this.form.from.city == "" ||
        this.form.from.zip == "" ||
        this.form.to.country == "" ||
        this.form.to.state == "" ||
        this.form.to.city == "" ||
        this.form.to.zip == ""
      ) {
        this.popupTogal = true;
        this.popupData = "Please provide a valid address!";
      } else {
        if (
          this.checkState(this.form.from.state) &&
          this.checkCity(this.form.from.city)
        ) {
          if (this.checkState(this.form.to.state) && this.checkCity(this.form.to.city)) {
            this.$router.push("/order/moving-types");
          } else {
            this.popupTogal = true;
            this.popupData = `The destination is out of our current service area. We are working on expanding our <a href="https://tingsapp.com/cities">coverage</a>`;
          }
        } else {
          this.popupTogal = true;
          this.popupData = `The pickup location is out of our current service area. We are working on expanding our  <a href="https://tingsapp.com/cities">coverage</a>`;
        }
        //
      }
    },
    init() {
      let from = localData.read("from");
      if (from) {
        this.isSupportedFrom = true;
        this.form.from.country = from.country;
        this.form.from.state = from.state;
        this.form.from.city = from.city;
        this.form.from.zip = from.zip;
        this.form.from.street = from.street;
        this.form.from.street_number = from.street_number;
        this.form.from.formatted_address = from.formatted_address;
      }
      let to = localData.read("to");
      if (to) {
        this.isSupportedTo = true;
        this.form.to.country = to.country;
        this.form.to.state = to.state;
        this.form.to.city = to.city;
        this.form.to.zip = to.zip;
        this.form.to.street = to.street;
        this.form.to.street_number = to.street_number;
        this.form.to.formatted_address = to.formatted_address;
      }
    },
    cities() {
      axios
        .get("state-cities")
        .then((res) => {
          console.log("cities in googleaddress2", res.data);
          this.supportedData = res.data;
        })
        .catch((err) => console.log(err));
    },

    getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(this.getReverseGeocodingData);
      } else {
        console.log("Geolocation is not supported by this browser.");
      }
    },

    getReverseGeocodingData(position) {
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
      this.form.from.latlng = {
        lat: lat,
        lng: lng,
      };
      var latlng = new google.maps.LatLng(lat, lng);
      // This is making the Geocode request
      var geocoder = new google.maps.Geocoder();
      geocoder.geocode({ latLng: latlng }, (results, status) => {
        if (status !== google.maps.GeocoderStatus.OK) {
          alert(status);
        }
        // This is checking to see if the Geoeode Status is OK before proceeding
        if (status == google.maps.GeocoderStatus.OK) {
          this.initCurrentLocation(results[0]);
        }
      });
    },
    initCurrentLocation(data) {
      let $vm = this;
      let components = data.address_components;
      $vm.form.from.formatted_address = data.formatted_address;
      components.forEach(function (component) {
        let types = component.types;
        if (types.indexOf("street_number") > -1) {
          $vm.form.from.street_number = component.long_name;
        }
        if (types.indexOf("route") > -1) {
          $vm.form.from.street = component.long_name;
        }
        if (types.indexOf("locality") > -1) {
          $vm.form.from.city = component.long_name;
        }
        if (types.indexOf("administrative_area_level_1") > -1) {
          $vm.form.from.state = component.short_name;
        }
        if (types.indexOf("postal_code") > -1) {
          $vm.form.from.zip = component.long_name;
        }
        if (types.indexOf("country") > -1) {
          $vm.form.from.country = component.long_name;
        }
      });
      localData.save("from", this.form);
      console.log("exit: ", this.form);
    },
  },
};
</script>

<style lang="scss" scoped>
.google-address2 {
  width: 100%;
  form {
    position: relative;
    input {
      font-family: "Roboto";
      width: 78%;
      margin-bottom: 10px;
      font-size: 18px;
      background: #00000017;
      border: none;
      padding: 22px 22px 22px 62px;
      border-radius: 5px;
      padding-right: 40px;
    }
    input:focus {
      background: #fff;
    }
    img {
      position: absolute;
      margin: 28px 25px;
    }
    .near-me {
      margin: -42px;
    }
    .md-menu {
      margin: -42px;
      color: #000 !important;
    }
  }
}
@media only screen and (max-width: 600px) {
  form {
    position: relative;
    input {
      width: 100% !important;
      font-size: 15px !important;
      padding: 16px 39px 16px 50px !important;
    }
    img {
      margin: 22px 18px 0px 18px !important;
      max-height: 69px !important;
    }
    .md-menu {
      position: absolute;
      margin: 10px -36px !important;
    }
  }
}
</style>
