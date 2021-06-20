<template>
  <div class="origin">
    <h3>What is your moving type?</h3>
    <div class="break"></div>
    <form v-if="types">
      <div class="break"></div>
      <div class="break"></div>
      <div class="row">
        <div class="col" v-for="type in types" :key="type.id" @click="select(type)">
          <b-card class="mini-card px-0 shadow-sm border-0">
            <div class="icon">
              <img
                :src="'/images/uploads/checked.svg'"
                v-if="selectedIndex == type.code"
                width="22"
                alt=""
              />
              <img :src="'/images/uploads/unchecked.svg'" v-else width="22" alt="" />
            </div>
            <div class="text">
              <h6>{{ type.title }}</h6>
            </div>
          </b-card>
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <b-button @click="$router.push('/')" variant="light">
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
  components: {
    Toaster,
  },
  data: () => ({
    types: [],
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
        localData.save("moving-type", this.selected);
        switch (this.selected.code) {
          case "office":
            localData.remove("moving-items");
            this.$router.push("office-sizes");
            break;
          case "apartment":
            localData.remove("moving-items");
            this.$router.push("moving-sizes");
            break;
          case "few_items":
            localData.remove("supplies");
            localData.remove("vehicle");
            localData.remove("number-of-movers");
            localData.remove("moving-size");
            localData.remove("office-size");
            this.$router.push("few-items");
            break;
          case "junk_removal":
            localData.remove("supplies");
            localData.remove("vehicle");
            localData.remove("number-of-movers");
            localData.remove("moving-size");
            localData.remove("office-size");
            this.$router.push("few-items");
            break;
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
        .get("moving-types")
        .then((res) => {
          this.types = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    init() {
      let data = localData.read("moving-type");
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
