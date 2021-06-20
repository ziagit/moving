<template>
  <div class="origin">
    <h3>How many movers do you need?</h3>
    <div class="break"></div>
    <form v-if="movers">
      <div class="break"></div>
      <div class="break"></div>

      <div class="row">
        <div class="col" v-for="mover in movers" :key="mover.id" @click="select(mover)">
          <b-card class="mini-card px-0 shadow-sm border-0">
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
              <h6 class="mb-1">{{ mover.number }}</h6>
              <small class="text-muted">{{ mover.recommended }}</small>
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
    movers: null,
    selected: null,
    selectedIndex: null,
    togal: false,
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
    back() {
      this.$router.push("/order/vehicle-sizes");
    },
    next() {
      if (this.selected != null) {
        localData.save("number-of-movers", this.selected);
        this.$router.push("floors");
      } else {
        this.$refs.toaster.show(
          "danger",
          "b-toaster-top-center",
          "Error",
          "Select an option to continue!"
        );
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

<style lang="scss" scoped>
.text-muted {
  margin: 0;
  padding: 0;
  line-height: 1;
}
</style>
