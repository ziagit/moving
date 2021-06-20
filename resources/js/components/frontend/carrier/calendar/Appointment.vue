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
    <div class="submit mt-3">
      <div class="sign">
        <div></div>
        <span class="md-caption">Disabled (Customers can't book)</span>
      </div>
      <b-button variant="primary" @click="submit()">Submit</b-button>
    </div>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import Toaster from "../../../shared/Toaster";
import Datepicker from "vuejs-datepicker";
export default {
  name: "Callendar",
  props: ["initDate"],
  components: {
    Datepicker,
    Toaster,
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
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-center",
          "Error",
          "Please select a date to submit!"
        );
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
