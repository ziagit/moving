<template>
  <div class="origin">
    <span class="md-display-1">Do movers need to use stairs?</span>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="next()">
      <div class="row">
        <div class="checkbox-container">
          <md-checkbox type="checkbox" v-model="isPickup" @change="pickupTogal($event)">
            At pickup site</md-checkbox
          >
        </div>
        <md-field v-if="isPickup">
          <label>Number of floors</label>
          <md-input
            type="number"
            v-model="form.pickup"
            :required="isPickup"
            :min="2"
          ></md-input>
        </md-field>
      </div>
      <div class="row" v-if="type.code != 'junk_removal'">
        <div class="checkbox-container">
          <md-checkbox
            type="checkbox"
            v-model="isDestination"
            @change="destinationTogal($event)"
            >At destination</md-checkbox
          >
        </div>
        <md-field v-if="isDestination">
          <label>Number of floors</label>
          <md-input
            type="number"
            v-model="form.destination"
            :required="isDestination"
            :min="2"
          ></md-input>
        </md-field>
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
          type="submit"
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
import Snackbar from "../../shared/Snackbar";
import localData from "../services/localData";
export default {
  name: "floor",
  components: {
    Snackbar,
  },
  data() {
    return {
      form: {
        pickup: null,
        destination: null,
      },
      isPickup: false,
      isDestination: false,
      type: null,
      snackbar: {
        show: false,
        message: null,
        statusCode: null,
      },
    };
  },
  created() {
    localData.save("cr", this.$router.currentRoute.path);
    this.$emit("progress", 4);
    this.init();
  },
  methods: {
    pickupTogal(e) {
      if (!e) {
        this.form.pickup = null;
      }
      this.isPickup = e;
    },
    destinationTogal(e) {
      if (!e) {
        this.form.destination = null;
      }
      this.isDestination = e;
    },
    next() {
      localData.save("floors", this.form);
      this.$router.push("moving-date");
    },
    back() {
      let item = localData.read("moving-items");
      if (item) {
        this.$router.push("/order/few-items");
      } else {
        this.$router.push("/order/number-of-movers");
      }
    },
    init() {
      this.type = localData.read("moving-type");
      let data = localData.read("floors");
      if (data) {
        if (data.pickup) {
          this.form.pickup = data.pickup;
          this.isPickup = true;
        }
        if (data.destination) {
          this.form.destination = data.destination;
          this.isDestination = true;
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.origin {
  .row {
    .checkbox-container {
      display: flex;
      align-items: center;
      width: 100%;
    }
  }
}

@media only screen and (max-width: 600px) {
}
</style>
