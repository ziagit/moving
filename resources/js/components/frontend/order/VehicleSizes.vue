<template>
  <div class="origin">
    <span class="md-display-1">What size vehicle do you prefer?</span>
    <div class="break"></div>
    <form v-if="vehicles">
      <div class="break"></div>
      <div class="break"></div>
      <div class="row">
        <div
          class="col"
          v-for="vehicle in vehicles"
          :key="vehicle.id"
          @click="select(vehicle)"
        >
          <md-card>
            <div class="icon">
              <img
                :src="'/images/uploads/checked.svg'"
                v-if="selectedIndex == vehicle.code"
                width="22"
              />
              <img :src="'/images/uploads/unchecked.svg'" v-else width="22" />
            </div>
            <div class="text">
              <div class="md-display-1">{{ vehicle.name }}</div>
              <div class="md-body-1" v-if="vehicle.recommended">
                {{ vehicle.recommended }}
              </div>
            </div>
          </md-card>
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <md-button
          @click="back()"
          class="md-raised md-fab md-icon-button rounded-primary-button"
        >
          <md-icon>arrow_back</md-icon>
        </md-button>
        <div class="tab"></div>

        <md-button
          @click="next()"
          class="md-raised md-fab md-icon-button rounded-secondary-button"
        >
          <md-icon>arrow_forward</md-icon>
        </md-button>
      </div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>
<script>
import localData from "../services/localData";
import Snackbar from "../../shared/Snackbar";
export default {
  name: "Origin",
  components: { Snackbar },
  data: () => ({
    vehicles: null,
    selected: null,
    selectedIndex: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    this.$emit("progress", 2);
    this.get();
    this.init();
    localData.save("cr", this.$router.currentRoute.path);
  },
  mounted() {
    window.scrollTo(0, 0);
  },
  methods: {
    select(vehicle) {
      this.selected = vehicle;
      this.selectedIndex = vehicle.code;
    },
    back() {
      var type = localData.read("moving-type");
      if (type.code == "office") {
        this.$router.push("/order/office-sizes");
      } else {
        this.$router.push("/order/moving-sizes");
      }
    },
    next() {
      if (this.selected != null) {
        localData.save("vehicle", this.selected);
        this.$router.push("number-of-movers");
      } else {
        this.snackbar.show = true;
        this.snackbar.message = "Select an option to continue!";
        this.snackbar.statusCode = "428";
      }
    },
    get() {
      axios
        .get("vehicles")
        .then((res) => {
          this.vehicles = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    init() {
      let data = localData.read("vehicle");
      if (data) {
        this.selected = data;
        this.selectedIndex = data.code;
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@media only screen and (max-width: 600px) {
}
</style>
