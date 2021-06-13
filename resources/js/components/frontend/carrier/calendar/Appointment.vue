<template>
  <div>
    <Datepicker
      :inline="true"
      v-model="state.date"
      :highlighted="state.highlighted"
      :disabledDates="state.disabledDates"
      :format="state.DatePickerFormat"
      name="datepicker"
      @selected="dateSelected()"
    />
    <div class="submit">
      <div class="sign">
        <div></div>
        <span class="md-caption">Disabled (Customers can't book)</span>
      </div>
      <md-button class="md-primary" @click="submit()">Submit</md-button>
    </div>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import Snackbar from "../../../shared/Snackbar";
import Datepicker from "vuejs-datepicker";
export default {
  name: "Callendar",
  props: ["initDate"],
  components: {
    Datepicker,
    Snackbar,
  },
  data: () => ({
    state: {
      DatePickerFormat: "yyyy MM dd",
      date: new Date(),
      highlighted: {
        dates: [],
      },
      disabledDates: {
        to: new Date(new Date()),
        dates: [
          // Disable an array of dates
        ],
      },
    },
    form: {
      year: null,
      month: null,
      day: null,
    },
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  methods: {
    dateSelected(e) {
      this.$nextTick(() => {
        this.form.month = this.state.date.getMonth() + 1; //months from 1-12
        this.form.day = this.state.date.getDate();
        this.form.year = this.state.date.getFullYear();
      });
    },
    submit() {
      if (this.form.month == null && this.form.year == null && this.form.day == null) {
        this.snackbar.show = true;
        this.snackbar.message = "Please select a date to submit!";
        this.snackbar.statusCode = 400;
      } else {
        axios
          .post("carrier/calendar", this.form)
          .then((res) => {
            console.log("saved successfully", res.data);
            this.$emit("close-dialog");
          })
          .catch((err) => console.log(err));
      }
    },
  },

  created() {
    this.state.highlighted.dates = this.initDate.dates;
    console.log("hilighted dates", this.state.highlighted.dates);
  },
};
</script>
<style scoped lang="scss">
.submit {
  display: flex;
  justify-content: space-between;
  .sign {
    display: flex;
    align-items: center;
    div {
      width: 10px;
      height: 10px;
      background: #cae5ed;
      margin: 5px;
    }
  }
}
</style>
