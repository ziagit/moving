<template>
  <div>
    <b-modal
      id="modal-lg"
      size="lg"
      title="Select dates to enable/disable"
      :hide-footer="true"
    >
      <div>
        <Appointment v-on:close-dialog="refresh" :initDate="state.disabledDates" />
      </div>
    </b-modal>
    <b-card header="Calendar" class="border-0 shadow text-left">
      <div class="actions">
        <b-button variant="light">
          <img :src="'/images/uploads/google-calendar.svg'" width="25" alt="" />
        </b-button>
        <b-button v-b-modal.modal-lg variant="light"
          ><img :src="'/images/uploads/booking-pending.svg'" width="25" alt="" />
        </b-button>
      </div>
      <Datepicker
        :inline="true"
        v-model="state.date"
        :disabledDates="state.disabledDates"
        :calendar-button="true"
        calendar-button-icon="fa fa-calendar"
        :bootstrap-styling="true"
        :disabled="true"
      />
    </b-card>
  </div>
</template>

<script>
import Appointment from "./Appointment";
import Datepicker from "vuejs-datepicker";
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
    refresh() {
      this.get();
      this.$root.$emit("bv::hide::modal", "modal-lg");
      this.appointmentTogal = false;
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
.actions {
  position: absolute;
  top: 1px;
  right: 1px;
}

.md-dialog {
  min-height: 400px !important;
  max-width: 1000px !important;
  margin: auto;
}
.input-group {
  display: none !important;
}
</style>
