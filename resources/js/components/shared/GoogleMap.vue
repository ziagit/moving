<template>
  <div>
    <div id="map" ref="map" :style="{ height: size }"></div>
  </div>
</template>
<script>
const directionsService = new google.maps.DirectionsService();
const directionsRenderer = new google.maps.DirectionsRenderer();
import localData from "../frontend/services/localData";
export default {
  name: "Map",
  props: ["newSize"],
  data() {
    return {
      origin: null,
      destination: null,
      map: null,
      center: { lat: 49.246292, lng: -123.116226 },
      originLatLng: null,
      destinationLatLng: null,
      size: null,
    };
  },
  watch: {
    newSize: function (newValue, oldValue) {
      this.size = newValue;
      this.initMap();
    },
  },
  methods: {
    initMap() {
      const map = new google.maps.Map(document.getElementById("map"), {
        center: this.center,
        zoom: 2,
        disableDefaultUI: true,
      });
      directionsRenderer.setMap(map);

      // Create markers.
      const features = [
        {
          position: new google.maps.LatLng(this.originLatLng),
          type: "info",
        },
        {
          position: new google.maps.LatLng(this.destinationLatLng),
          type: "info",
        },
      ];
      var iconBase = "https://maps.google.com/mapfiles/kml/shapes/";
      for (let i = 0; i < features.length; i++) {
        const marker = new google.maps.Marker({
          position: features[i].position,
          icon: iconBase + "parking_lot_maps.png", //icons[features[i].type].icon,
          map: map,
        });
      }
    },
    async setOrigin(from, latlng) {
      this.originLatLng = latlng;
      var to = localData.read("to");
      this.destination = to != null ? to.formatted_address : null;
      this.origin = from.formatted_address;
      await this.calculateAndDisplayRoute();
      console.log("yyyyyyy", localData.read("distance"), localData.read("duration"));
    },
    setDestination: function (to, latlng) {
      this.destinationLatLng = latlng;
      var from = localData.read("from");
      this.origin = from != null ? from.formatted_address : null;
      this.destination = to.formatted_address;
      this.calculateAndDisplayRoute();
    },

    calculateAndDisplayRoute() {
      if (this.origin != null && this.destination != null) {
        directionsService.route(
          {
            origin: this.origin,
            destination: this.destination,
            travelMode: google.maps.TravelMode.DRIVING,
          },
          (response, status) => {
            if (status === google.maps.DirectionsStatus.OK && response) {
              directionsRenderer.setDirections(response);
              const route = response.routes[0];
              for (let i = 0; i < route.legs.length; i++) {
                const routeSegment = i + 1;
                localData.save(
                  "distance",
                  (route.legs[i].distance.value / 1000).toFixed(1)
                );
                localData.save("duration", (route.legs[i].duration.value / 60).toFixed());

                console.log(
                  "xxxxxxxxx",
                  localData.read("distance"),
                  localData.read("duration")
                );
              }
            } else {
              window.alert("Directions request failed due to " + status);
            }
          }
        );
      }
    },
    init() {
      var from = localData.read("from");
      var to = localData.read("to");
      if (from != null) {
        this.origin = from.formatted_address;
        if (to != null) {
          this.destination = to.formatted_address;
          this.calculateAndDisplayRoute();
        }
      }
    },
  },
  mounted() {
    this.initMap();
  },
  created() {
    this.size = this.newSize;
    this.init();
  },
};
</script>
<style lang="scss" scoped>
#map {
  //width: 400px;
  border-top-left-radius: 5px;
  border-top-right-radius: 5px;
}
@media only screen and (max-width: 600px) {
  #map {
    width: 100%;
    height: calc(100vh - 50px);
  }
}
</style>
