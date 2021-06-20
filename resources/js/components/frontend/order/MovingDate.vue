<template>
  <div class="origin">
    <span class="md-display-1">When should be picked up?</span>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="next()">
      <div v-if="nextMonthTogal">
        <CustomCalendar />
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
import localData from "../services/localData";
import CustomCalendar from "../../shared/CustomCalendar";
import NextMonthCalendar from "../../shared/NextMonthCalendar";
import Toaster from "../../shared/Toaster";
export default {
  name: "PickupDate",
  components: {
    CustomCalendar,
    Toaster,
    NextMonthCalendar,
  },
  data: () => ({
    initDate: null,
    timeSelected: null,
    nextMonthTogal: true,
    type: localData.read("moving-type"),
  }),

  created() {
    this.progress();
    localData.save("cr", this.$router.currentRoute.path);
  },
  methods: {
    progress() {
      if (this.type.code == "few_items" || this.type.code == "junk_removal") {
        this.$emit("progress", 6);
      } else {
        this.$emit("progress", 5);
      }
    },
    back() {
      this.$router.push("/order/floors");
    },
    next() {
      var date = localData.read("moving-date");
      if (date && date.date != null && date.time != null) {
        if (this.type.code == "few_items" || this.type.code == "junk_removal") {
          this.$router.push("movers");
        } else {
          this.$router.push("moving-supplies");
        }
      } else {
        this.$refs.toaster.show(
          "danger",
          "b-toaster-top-center",
          "Error",
          "Select a date and time to continue!"
        );
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.origin {
  text-align: center;
  width: 100%;
  .time-range {
    display: flex;
    flex-wrap: wrap;
    .time {
      background: #ffa5001a;
      padding: 5px;
      margin: 3px;
      min-width: 115px;
      border-radius: 3px;
      cursor: pointer;
      box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
        0 1px 5px 0 rgb(0 0 0 / 12%);
      font-size: 12px;
    }
    .time:hover {
      box-shadow: none;
    }
  }

  .actions {
    display: flex;
    justify-content: center;
  }
}
.selected {
  background: #ffa500 !important;
  color: #fff;
}
@media only screen and (max-width: 600px) {
}
</style>
