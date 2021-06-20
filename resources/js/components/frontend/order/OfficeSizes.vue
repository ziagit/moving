<template>
  <div class="origin">
    <span class="md-display-1">What is the size of office?</span>
    <div class="break"></div>
    <form v-if="sizes">
      <div class="break"></div>
      <div class="break"></div>
      <div class="row">
        <div class="col" v-for="size in sizes" :key="size.id" @click="select(size)">
          <b-card class="mini-card px-0 shadow-sm border-0">
            <div class="icon">
              <img
                :src="'/images/uploads/checked.svg'"
                v-if="selectedIndex == size.code"
                width="22"
                alt=""
              />
              <img :src="'/images/uploads/unchecked.svg'" v-else width="22" alt="" />
            </div>
            <div class="text">
              <div class="md-display-1">{{ size.title }}</div>
              <div class="md-body-1">{{ size.employees }}</div>
            </div>
          </b-card>
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <md-button
          to="/order/moving-types"
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
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import localData from "../services/localData";
import Toaster from "../../shared/Toaster";
export default {
  name: "Origin",
  components: {
    Toaster,
  },
  data: () => ({
    sizes: [],
    selected: null,
    selectedIndex: null,
  }),
  created() {
    this.$emit("progress", 1);
    this.get();
    this.init();
    localData.save("cr", this.$router.currentRoute.path);
  },
  mounted() {
    window.scrollTo(0, 0);
  },
  methods: {
    select(size) {
      this.selected = size;
      this.selectedIndex = size.code;
    },
    next() {
      if (this.selected != null) {
        if (this.selected.code == "fewitems") {
          localData.remove("vehicle");
          localData.remove("number-of-movers");
          localData.save("moving-size", this.selected);
          this.$router.push("few-items");
        } else {
          localData.remove("moving-items");
          localData.save("moving-size", this.selected);
          this.$router.push("vehicle-sizes");
        }
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
        .get("office-sizes")
        .then((res) => {
          this.sizes = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    init() {
      let data = localData.read("moving-size");
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
  .origin {
    .options {
      text-align: center;
    }
  }
}
</style>
