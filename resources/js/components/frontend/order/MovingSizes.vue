<template>
  <div class="origin">
    <h3>What is your moving size?</h3>
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
              <h6>{{ size.title }}</h6>
              <small class="text-muted">{{ size.recommended }}</small>
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
    back() {
      this.$router.push("/order/moving-types");
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
        .get("moving-sizes")
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
.text-muted {
  margin: 0;
  padding: 0;
  line-height: 1;
}
@media only screen and (max-width: 600px) {
  .origin {
    .options {
      text-align: center;
    }
  }
}
</style>
