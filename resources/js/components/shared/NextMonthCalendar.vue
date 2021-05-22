<template>
  <div class="container">
    <div class="days" v-for="(cl, index) in cal" :key="index" @click="select(cl)">
      <div class="content" v-bind:class="{ selected: cl == selected }">
        <div class="day">
          {{ cl.day }}
        </div>
        <div class="date">
          {{ cl.date }}
          <div
            v-if="cl.icon"
            style="display: flex; flex-direction: column; padding: 10px"
          >
            <md-icon>{{ cl.icon }}</md-icon>

            <span style="font-size: 12px">{{ cl.next }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "NextMonthCalendar",
  props: ["initDate"],
  data: () => ({
    selected: null,
    cal: [],
  }),
  components: {},
  created() {
    this.getDaysInMonthUTC();
  },
  methods: {
    select(sl) {
      console.log("slected: ", sl);
      this.selected = sl;
      this.$emit("date-selected", sl);
    },
    getDaysInMonthUTC() {
      var object = new Date();
      var month = object.getMonth() + 1;
      var day = object.getDay();
      var date = object.getDate();
      var year = object.getFullYear();
      var daysInMonth = new Date(year, month, 0).getDate();
      for (var i = 1; i < daysInMonth + 1; i++) {
        this.cal.push({
          day: this.getName(day),
          date: i,
          month: month,
          year: year,
        });
        day++;
        day > 6 ? (day = 0) : day;
        date++;
      }
      this.cal.push({
        icon: "arrow_drop_up",
        next: "Less",
      });
    },
    getName(num) {
      switch (num) {
        case 0:
          return "Sun";
        case 1:
          return "Mon";
        case 2:
          return "Tue";
        case 3:
          return "Wed";
        case 4:
          return "Thu";
        case 5:
          return "Fri";
        case 6:
          return "Sat";
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.container {
  padding: 0px;
  display: grid;
  grid-template-columns: repeat(auto-fit, 50px);
  grid-auto-rows: 50px;
  justify-content: center;
  gap: 1.5rem 1.5rem;

  .days {
    width: 63px;
    height: 63px;
    min-width: 63px;
    margin: 5px;
    background: #ffa5001a;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
      0 1px 5px 0 rgb(0 0 0 / 12%);
    .content {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      text-align: center;
      justify-content: center;
      border-radius: 12px;
    }
    .day {
      font-size: 11px;
      line-height: 11px;
    }
    .date {
      font-size: 22px;
      font-weight: 600;
      line-height: 26px;
    }
    .next-month {
      background: #ffa500;
      color: #fff;
    }
    .selected {
      background: #ffa500 !important;
      color: #fff;
    }
  }
  .days:hover {
    box-shadow: none;
  }
}
::-webkit-scrollbar {
  display: none;
}
</style>
