<template>
  <div class="pickup-date">
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
        <md-button
          to="/order/floors"
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
import localData from "../services/localData";
import CustomCalendar from "../../shared/CustomCalendar";
import NextMonthCalendar from "../../shared/NextMonthCalendar";
import Snackbar from "../../shared/Snackbar";
import axios from "axios";
export default {
  name: "PickupDate",
  components: {
    CustomCalendar,
    Snackbar,
    NextMonthCalendar,
  },
  data: () => ({
    initDate: null,
    timeSelected: null,
    nextMonthTogal: true,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
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
    next() {
      var date = localData.read("moving-date");
      if (date && date.date != null && date.time != null) {
        if (this.type.code == "few_items" || this.type.code == "junk_removal") {
          this.$router.push("movers");
        } else {
          this.$router.push("moving-supplies");
        }
      } else {
        this.snackbar.show = true;
        this.snackbar.message = "Select a date and time to continue!";
        this.snackbar.statusCode = "428";
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.pickup-date {
  text-align: center;
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
