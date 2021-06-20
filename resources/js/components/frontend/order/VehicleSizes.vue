<template>
  <div class="origin">
    <h3>What size vehicle do you prefer?</h3>
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
          <b-card class="mini-card px-0 shadow-sm border-0">
            <div class="icon">
              <img
                :src="'/images/uploads/checked.svg'"
                v-if="selectedIndex == vehicle.code"
                width="22"
              />
              <img :src="'/images/uploads/unchecked.svg'" v-else width="22" />
            </div>
            <div class="text">
              <h6>{{ vehicle.name }}</h6>
              <small class="text-muted" v-if="vehicle.recommended">
                {{ vehicle.recommended }}
              </small>
            </div>
          </b-card>
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>

      <div class="actions">
        <b-button @click="back()" variant="light">
          <b-icon icon="arrow-left"></b-icon>
        </b-button>
        <div class="tab"></div>
        <b-button @click="next()" variant="primary">
          <b-icon icon="arrow-right"></b-icon>
        </b-button>
      </div>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>
<script>
import localData from "../services/localData";
import Toaster from "../../shared/Toaster";
export default {
  name: "Origin",
  components: { Toaster },
  data: () => ({
    vehicles: null,
    selected: null,
    selectedIndex: null,
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
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-center",
          "Warning",
          "Select an option to continue!"
        );
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
.text-muted {
  margin: 0;
  padding: 0;
  line-height: 1;
}
@media only screen and (max-width: 600px) {
}
</style>
