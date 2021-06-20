<template>
  <div class="origin">
    <h3>Do movers need to use stairs?</h3>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="next()" class="ml-5 text-left">
      <b-form-group>
        <b-form-checkbox
          variant="warning"
          v-model="isPickup"
          name="check-button"
          @change="pickupTogal($event)"
        >
          At pickup site
        </b-form-checkbox>
      </b-form-group>
      <b-form-group>
        <b-form-input
          v-if="isPickup"
          id="input-1"
          type="number"
          v-model="form.pickup"
          :required="isPickup"
          :min="2"
          placeholder="Number of floors"
        ></b-form-input>
      </b-form-group>
      <div v-if="type.code != 'junk_removal'">
        <b-form-group>
          <b-form-checkbox
            v-model="isDestination"
            name="check-button"
            @change="destinationTogal($event)"
          >
            At destination
          </b-form-checkbox>
        </b-form-group>
        <b-form-group>
          <b-form-input
            v-if="isDestination"
            id="input-1"
            type="number"
            v-model="form.destination"
            :required="isDestination"
            :min="2"
            placeholder="Number of floors"
          ></b-form-input>
        </b-form-group>
      </div>

      <div class="break"></div>
      <div class="break"></div>

      <div class="actions">
        <b-button @click="back()" variant="light">
          <b-icon icon="arrow-left"></b-icon>
        </b-button>
        <div class="tab"></div>
        <b-button type="submit" variant="primary">
          <b-icon icon="arrow-right"></b-icon>
        </b-button>
      </div>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import Toaster from "../../shared/Toaster";
import localData from "../services/localData";
export default {
  name: "floor",
  components: {
    Toaster,
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
  text-align: center;
  width: 100%;
  .checkbox-container {
    display: flex;
    align-items: center;
    width: 70%;
    text-align: left;
  }
}

@media only screen and (max-width: 600px) {
}
</style>
