<template>
  <div class="origin">
    <span class="md-display-1">How many movers do you need?</span>
    <div class="break"></div>
    <form v-if="movers">
      <div class="break"></div>
      <div class="break"></div>

      <div class="row">
        <div class="col" v-for="mover in movers" :key="mover.id" @click="select(mover)">
          <md-card>
            <div class="icon">
              <img
                :src="'/images/uploads/checked.svg'"
                v-if="selectedIndex == mover.code"
                width="22"
                alt=""
              />
              <img :src="'/images/uploads/unchecked.svg'" v-else width="22" alt="" />
            </div>
            <div class="text">
              <div class="md-display-1">{{ mover.number }}</div>
              <div class="md-body-1">{{ mover.recommended }}</div>
            </div>
          </md-card>
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <md-button
          to="/order/vehicle-sizes"
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
    movers: null,
    selected: null,
    selectedIndex: null,
    togal: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    this.$emit("progress", 3);
    this.init();
    this.get();
    localData.save("cr", this.$router.currentRoute.path);
  },
  methods: {
    select(mover) {
      this.selected = mover;
      this.selectedIndex = mover.code;
    },
    next() {
      if (this.selected != null) {
        localData.save("number-of-movers", this.selected);
        this.$router.push("floors");
      } else {
        this.snackbar.show = true;
        this.snackbar.message = "Select an option to continue!";
        this.snackbar.statusCode = "428";
      }
    },
    get() {
      axios
        .get("mover-numbers")
        .then((res) => {
          this.movers = res.data;
          console.log("num of movers: ", this.movers);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    init() {
      let data = localData.read("number-of-movers");
      if (data) {
        this.selected = data;
        this.selectedIndex = data.code;
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
