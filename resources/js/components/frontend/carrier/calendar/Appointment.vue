<template>
  <div class="container">
    <div class="days" v-for="(cl, index) in allDates" :key="index" @click="select(cl)">
      <div
        class="content"
        v-bind:class="{
          selected: isSelected(cl),
        }"
      >
        <div class="day">
          {{ cl.day }}
        </div>
        <div class="date">
          {{ cl.date }}
        </div>
      </div>
    </div>
    <div class="footer">
      <md-button class="md-primary">Disable</md-button>
      <md-button class="md-primary">Enable</md-button>
    </div>
  </div>
</template>
<script>
import services from "../../services/functions";
var months = [
  "Jan",
  "Feb",
  "Mar",
  "Apr",
  "May",
  "Jun",
  "Jul",
  "Aug",
  "Sep",
  "Oct",
  "Nov",
  "Dec",
];
var dateObject = new Date();
export default {
  name: "Callendar",
  props: ["initDate"],
  data: () => ({
    allDates: [],
    disabledDates: [],
    selectedDates: [],
  }),
  methods: {
    getallDates() {
      var month = dateObject.getMonth() + 1;
      var day = dateObject.getDay();
      var date = dateObject.getDate();
      var year = dateObject.getFullYear();
      var daysInMonth = new Date(year, month, 0).getDate();
      for (var i = dateObject.getDate(); i < daysInMonth + 1; i++) {
        this.allDates.push({
          day: services.getDaysName(day),
          date: date,
          month: month,
          year: year,
        });
        day++;
        day > 6 ? (day = 0) : day;
        date++;
      }
    },
    select(sl) {
      this.selectedDates.push({
        date: sl.date,
        day: sl.day,
        month: sl.month,
        year: sl.year,
      });
      console.log("selected: ", this.selectedDates);
    },
    isSelected(cl) {
      for (let i = 0; i < this.selectedDates.length; i++) {
        if (
          cl.date == this.selectedDates[i].date &&
          cl.month == this.selectedDates[i].month
        ) {
          return true;
        } else {
          return false;
        }
      }
    },
    initDisabled() {
      this.initDate.dates.forEach((e) => {
        var d = new Date(e);
        this.disabledDates.push({
          date: d.getDate(),
          day: d.getDay(),
          month: d.getMonth() + 1,
          year: d.getFullYear(),
        });
      });
    },
  },
  components: {},
  created() {
    this.getallDates();
    this.initDisabled();
    this.selectedDates.push({
      date: 11,
      day: "Fri",
      month: 6,
      year: 2021,
    });
    console.log("seclected: ", this.selectedDates);
  },
};
</script>
<style scoped lang="scss">
.container {
  max-width: 532px;
  display: flex;
  flex-wrap: wrap;
  .days {
    margin: 5px;
    border: solid 0.5px #ffa500;
    width: 66px;
    border-radius: 5px;
    .content {
      padding: 5px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
  }
  .days:hover {
    cursor: pointer;
    background: #ffa500;
    color: #fff;
  }
}
.footer {
  width: 100%;
  text-align: right;
}
.selected {
  background: #ffa500 !important;
  color: #fff;
}
</style>
