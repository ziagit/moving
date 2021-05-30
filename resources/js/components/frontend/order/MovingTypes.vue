<template>
  <div class="origin">
    <span class="md-display-1">What is your moving type?</span>
    <div class="break"></div>
    <form v-if="types">
      <div class="break"></div>
      <div class="break"></div>
      <div class="row">
        <div class="col" v-for="type in types" :key="type.id" @click="select(type)">
          <md-card>
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
              <div class="md-display-1">{{ type.title }}</div>
            </div>
          </md-card>
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <md-button
          to="/home"
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
  components: {
    Snackbar,
  },
  data: () => ({
    types: [],
    selected: null,
    selectedIndex: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
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
        this.snackbar.show = true;
        this.snackbar.message = "Select an option to continue!";
        this.snackbar.statusCode = "428";
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
