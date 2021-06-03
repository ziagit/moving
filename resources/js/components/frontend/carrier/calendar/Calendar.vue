<template>
  <div>
    <md-dialog :md-active.sync="appointmentTogal">
      <md-dialog-title
        ><span class="md-body-2">Select dates to enable/disable</span></md-dialog-title
      >
      <md-dialog-content>
        <Appointment v-on:close-dialog="refresh" :initDate="state.disabledDates" />
      </md-dialog-content>
    </md-dialog>
    <md-card>
      <md-card-header>
        <span class="md-title">Calendar</span>
        <div>
          <md-button class="md-icon-button md-primary">
            <img :src="'/images/uploads/google-calendar.svg'" width="25" alt="" />
            <md-tooltip md-delay="300">Edit by Google Calendar</md-tooltip>
          </md-button>
          <md-button @click="openDialog()" class="md-icon-button md-primary"
            ><img :src="'/images/uploads/booking-pending.svg'" width="25" alt="" />
            <md-tooltip md-delay="300">Edit here</md-tooltip>
          </md-button>
        </div>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <Datepicker
          :inline="true"
          v-model="state.date"
          :disabledDates="state.disabledDates"
          :calendar-button="true"
          calendar-button-icon="fa fa-calendar"
          :bootstrap-styling="true"
          :disabled="true"
        />
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Appointment from "./Appointment";
import Datepicker from "vuejs-datepicker";
import axios from "axios";
export default {
  name: "Callendar",
  data: () => ({
    appointmentTogal: false,
    state: {
      date: new Date(),
      disabledDates: {
        to: new Date(new Date()),
        dates: [
          // Disable an array of dates
        ],
      },
    },
  }),
  components: {
    Datepicker,
    Appointment,
  },
  methods: {
    openDialog() {
      this.appointmentTogal = true;
    },
    refresh(year, month, day) {
      axios
        .post("carrier/calendar", { year: year, month: month, day: day })
        .then((res) => {
          console.log("saved successfully", res.data);
          this.formatIt(res.data);
          this.appointmentTogal = false;
        })
        .catch((err) => console.log(err));
    },
    formatIt(data) {
      var temp = [];
      data.forEach((element) => {
        temp.push(new Date(element.year, element.month - 1, element.day));
      });
      this.state.disabledDates.dates = temp;
    },
    get() {
      axios.get("carrier/calendar").then((res) => {
        this.formatIt(res.data);
      });
    },
  },
  created() {
    this.get();
  },
};
</script>
<style scoped lang="scss">
.md-card {
  text-align: center;
  .md-card-header {
    display: flex;
    justify-content: space-between;
    img:hover {
      opacity: 0.6;
      cursor: pointer;
    }
  }
}

.md-dialog {
  min-height: 400px !important;
  max-width: 1000px !important;
  margin: auto;
}
</style>
