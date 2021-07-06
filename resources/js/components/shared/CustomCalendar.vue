<template>
  <div class="calendar">
    <!-- edit dialog -->
    <div class="row1" v-if="daysTogal">
      <div
        class="days"
        v-for="(cl, index) in cal"
        :key="index"
        @click="selectFromCurrentMonth(cl)"
      >
        <div
          class="content"
          v-bind:class="{
            selected:
              cl.date == (date.date ? date.date.date : '') &&
              cl.month == (date.date ? date.date.month : ''),
          }"
        >
          <div class="day" :class="cl.date == 1 ? 'next-month' : ''">
            {{ cl.day }}
          </div>
          <div class="date">
            <span v-if="cl.month">{{ cl.date }}</span>
            <b-icon v-else :icon="cl.date"></b-icon>
          </div>
        </div>
      </div>
    </div>
    <div class="row2" v-else>
      <div
        class="days"
        v-for="(cl, index) in allDays"
        :key="index"
        @click="selectFromNextMonth(cl)"
      >
        <div
          class="content"
          v-bind:class="{
            selected:
              cl.date == (date.date ? date.date.date : '') &&
              cl.month == (date.date ? date.date.month : ''),
          }"
        >
          <div class="day" :class="cl.date == 1 ? 'next-month' : ''">
            {{ cl.day }}
          </div>
          <div class="date">
            {{ cl.date }}
          </div>
        </div>
      </div>
      <div class="days" @click="moreTogal = !moreTogal">
        <div class="custom-cal">
          <input type="date" v-model="selectNextMonth" :min="getMinDate()" />
        </div>
      </div>
      <div
        class="days less"
        @click="daysTogal = !daysTogal"
        style="background: #fff; border: solid 1px #ffa500"
      >
        <div>
          <b-icon icon="chevron-up"></b-icon>
          <span style="font-size: 12px">Less</span>
        </div>
      </div>
    </div>
    <br /><br />
    <div v-if="daysTogal">
      <p>When is your prefered time to start the move?</p>
      <p v-if="timeLoading">loading...</p>
      <div class="time-range mb-4" v-else>
        <div v-for="(t, index) in myTimes" :key="index" @click="selectTime(t)">
          <div
            class="time"
            v-bind:class="{
              selected: t.from == (date.time ? date.time.from : ''),
            }"
          >
            {{ buildTime(t.from) }} - {{ buildTime(t.to) }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Datepicker from "vuejs-datepicker";
import localData from "../frontend/services/localData";
import services from "../frontend/services/functions";
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
  name: "CustomCalendar",
  components: {
    Datepicker,
  },
  data: () => ({
    selectNextMonth: null,
    daysTogal: true,
    timeLoading: false,
    times: [],
    myTimes: [],
    currentDate: new Date(),
    moreTogal: false,
    date: {
      date: null,
      time: null,
    },
    cal: [],
    allDays: [],
  }),
  watch: {
    selectNextMonth: function (value) {
      var d = new Date(value);
      this.date.date.date = d.getDate();
      this.date.date.month = d.getMonth() + 1;
      this.date.date.day = services.getDaysName(d.getDay());
      this.date.date.year = d.getFullYear();
      localData.save("moving-date", this.date);
    },
  },
  created() {
    this.getTimes(this.currentDate.getDate());
    this.initCal();
    this.getAllDays();
    this.init();
  },
  methods: {
    getMinDate() {
      var today = new Date();
      var dd = 1;
      var mm = today.getMonth() + 2; //January is 0!
      var yyyy = today.getFullYear();
      if (dd < 10) {
        dd = "0" + dd;
      }
      if (mm < 10) {
        mm = "0" + mm;
      }
      return (today = yyyy + "-" + mm + "-" + dd);
    },
    getTimes(date) {
      this.timeLoading = true;
      axios
        .get("times/" + date)
        .then((res) => {
          this.timeLoading = false;
          this.times = res.data;
          this.showTimes();
        })
        .catch((err) => console.log(err));
    },
    buildTime(time) {
      return time < 10 ? "0" + time + ":00" : time + ":00";
    },
    showTimes() {
      if (this.date.date) {
        if (this.date.date.date > this.currentDate.getDate()) {
          this.myTimes = this.times;
        } else {
          this.myTimes = [];
          this.times.forEach((element) => {
            if (element.from >= dateObject.getHours()) {
              this.myTimes.push(element);
            }
          });
        }
      }
    },
    init() {
      let local = localData.read("moving-date");
      if (local) {
        this.selectedIndex = local.date.date;
        this.date = local;
      }
    },
    selectTime(sl) {
      this.date.time = sl;
      localData.save("moving-date", this.date);
    },
    selectFromCurrentMonth(sl) {
      if (sl.month) {
        console.log("selected from current month", sl);
        this.date.date = sl;
        localData.save("moving-date", this.date);
        this.showTimes();
      } else {
        this.daysTogal = !this.daysTogal;
      }
    },
    selectFromNextMonth(sl) {
      console.log("selected from next month: ", sl);
      this.date.date = sl;
      localData.save("moving-date", this.date);
      this.daysTogal = !this.daysTogal;
    },

    initCal() {
      var month = dateObject.getMonth() + 1;
      var day = dateObject.getDay();
      var date = dateObject.getDate();
      var year = dateObject.getFullYear();
      var daysInMonth = new Date(year, month, 0).getDate();
      var nextMonth = months[dateObject.getMonth() + 1];
      var counter = 1;
      for (var i = dateObject.getDate(); i < dateObject.getDate() + 6; i++) {
        if (i <= daysInMonth) {
          this.cal.push({
            day: services.getDaysName(day),
            date: date,
            month: month,
            year: year,
          });
        } else {
          this.cal.push({
            day: counter == 1 ? nextMonth : services.getDaysName(day),
            date: counter,
            month: month + 1,
            year: year,
          });
          counter += 1;
        }
        day++;
        day > 6 ? (day = 0) : day;
        date++;
      }
      this.cal.push({
        day: "More",
        date: "chevron-down",
        month: null,
        year: null,
      });
    },
    getAllDays() {
      var month = dateObject.getMonth() + 1;
      var day = dateObject.getDay();
      var date = dateObject.getDate();
      var year = dateObject.getFullYear();
      var daysInMonth = new Date(year, month, 0).getDate();
      var nextMonth = months[dateObject.getMonth() + 1];
      for (var i = dateObject.getDate(); i < daysInMonth + 1; i++) {
        this.allDays.push({
          day: services.getDaysName(day),
          date: date,
          month: month,
          year: year,
        });
        day++;
        day > 6 ? (day = 0) : day;
        date++;
      }
      for (var i = 1; i < dateObject.getDate() - 3; i++) {
        this.allDays.push({
          day: i == 1 ? nextMonth : services.getDaysName(day),
          date: i,
          month: month + 1,
          year: year,
        });
        day++;
        day > 6 ? (day = 0) : day;
        date++;
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.row1 {
  display: grid;
  grid-template-columns: repeat(auto-fit, 54px);
  grid-auto-rows: 50px;
  justify-content: center;
  gap: 1.5rem 1.5rem;
  .days {
    width: 63px;
    min-width: 63px;
    height: 63px;
    margin: 10px;
    margin-right: 15px;
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
  }
  .days:hover {
    box-shadow: none;
  }
  .more {
    position: absolute;
    right: -8px;
    background: #fff;
    border: 1px solid #ffa500;
    div {
      display: flex;
      flex-direction: column;
      padding: 10px;
      align-items: center !important;
      height: 100%;
    }
  }
}
.row2 {
  display: grid;
  grid-template-columns: repeat(auto-fit, 54px);
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
  }
  .days:hover {
    box-shadow: none;
  }
  .less {
    display: flex;
    justify-content: center;
    align-items: center;
    div {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
  }
}
.time-range {
  display: grid;
  grid-template-columns: repeat(auto-fit, 97px);
  grid-auto-rows: 15px;
  justify-content: center;
  gap: 1.5rem 1.5rem;
  .time {
    background: #ffa5001a;
    padding: 5px;
    margin: 2px;
    min-width: 115px;
    border-radius: 3px;
    cursor: pointer;
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
      0 1px 5px 0 rgb(0 0 0 / 12%);
    font-size: 14px;
  }
  .time:hover {
    box-shadow: none;
  }
}
::-webkit-scrollbar {
  display: none;
}
.selected {
  background: #ffa500 !important;
  color: #fff;
}
@media only screen and (max-width: 600px) {
  .row1 {
  }
  .row2 {
    grid-template-columns: repeat(auto-fit, 50px);
    grid-auto-rows: 50px;
  }
}
</style>
