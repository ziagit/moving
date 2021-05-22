<template>
  <div>
    <Datepicker
      :inline="true"
      v-model="state.date"
      :disabledDates="state.disabledDates"
      :format="state.DatePickerFormat"
      name="datepicker"
      @selected="dateSelected()"
    />
    <md-button class="md-primary" @click="submit()">Submit</md-button>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
export default {
  name: "Callendar",
  props: ["initDate"],
  data: () => ({
    state: {
      DatePickerFormat: "yyyy MM dd",
      date: new Date(),
      disabledDates: {
        to: new Date(new Date()),
      },
    },
    year: null,
    month: null,
    day: null,
  }),
  methods: {
    dateSelected(e) {
      this.$nextTick(() => {
        this.month = this.state.date.getMonth() + 1; //months from 1-12
        this.day = this.state.date.getDate();
        this.year = this.state.date.getFullYear();
      });
    },
    submit() {
      if (this.month != null && this.year != null && this.day != null) {
        this.$emit("close-dialog", this.year, this.month, this.day);
      }
    },
  },
  components: {
    Datepicker,
  },
  created() {},
};
</script>
<style scoped>
.md-button {
  float: right;
}
</style>
