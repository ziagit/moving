<template>
  <div>
    <form @submit.prevent="submit">
      <md-datepicker v-model="form.from" :md-immediately="true" required>
        <label>Start of earning period</label>
      </md-datepicker>
      <md-datepicker v-model="form.to" :md-immediately="true" required>
        <label>End of earning period</label>
      </md-datepicker>
      <md-field>
        <md-select
          v-model="form.carrier"
          placeholder="Mover"
          @md-selected="getCost()"
          required
        >
          <md-option v-for="carrier in carriers" :key="carrier.id" :value="carrier.id">{{
            carrier.first_name
          }}</md-option>
        </md-select>
      </md-field>
      <Spinner v-if="isLoading" />
      <md-field v-else>
        <label>Amount</label>
        <span class="md-prefix">$</span>
        <md-input v-model="form.amount" :min="1" required></md-input>
      </md-field>
      <div v-if="notExist">This mover has no earning in their dashboard!</div>

      <div class="submit" v-else>
        <Spinner v-if="isSubmitting" />
        <md-button v-else type="submit" class="md-primary"> Save </md-button>
      </div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>
<script>
import Snackbar from "../../shared/Snackbar";
import Spinner from "../../shared/Spinner";
export default {
  name: "Add",
  components: { Spinner, Snackbar },
  data: () => ({
    carriers: null,
    form: {
      carrier: null,
      amount: null,
      from: null,
      to: null,
      earning_ids: [],
    },
    isSubmitting: false,
    isLoading: false,
    notExist: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/carrier-list")
        .then((res) => {
          this.carriers = res.data;
        })
        .catch((err) => console.log(err));
    },
    getCost() {
      this.isLoading = true;
      axios
        .get("admin/carrier-earnings/" + this.form.carrier)
        .then((res) => {
          console.log("all car earns", res.data);
          var total = 0;
          for (let i = 0; i < res.data.length; i++) {
            total = total + (res.data[i].carrier_earning + res.data[i].unpaid_gst);
            this.form.earning_ids.push(res.data[i].id);
          }
          if (total <= 0) {
            this.notExist = true;
          }
          this.form.amount = Math.round(total).toFixed(2);

          this.isLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
      console.log("costs: is", this.form.carrier);
    },
    submit() {
      if (
        this.form.from == null ||
        this.form.to == null ||
        this.form.carrier == null ||
        this.form.amount == null ||
        this.form.earning_ids.length < 1
      ) {
        this.snackbar.message = "All fields are required";
        this.snackbar.statusCode = "409";
        this.snackbar.show = true;
      } else {
        this.isSubmitting = true;
        axios.post("admin/payouts", this.form).then((res) => {
          console.log("res", res.data);
          this.isSubmitting = false;
          this.$emit("close-dialog");
        });
      }
    },
  },
};
</script>
<style lang="scss" scoped>
.submit {
  text-align: right;
}
</style>
