<template>
  <div>
    <form @submit.prevent="submit">
      <b-form-group>
        <b-form-datepicker
          v-model="form.from"
          placeholder="Start of earning period"
          required
        ></b-form-datepicker>
      </b-form-group>
      <b-form-group>
        <b-form-datepicker
          v-model="form.to"
          placeholder="End of earning period"
          required
        ></b-form-datepicker>
      </b-form-group>
      <b-form-group>
        <b-form-select
          v-model="form.carrier"
          placeholder="Mover"
          @change="getCost()"
          required
        >
          <option v-for="carrier in carriers" :key="carrier.id" :value="carrier.id">
            {{ carrier.first_name }}
          </option>
        </b-form-select>
      </b-form-group>
      <b-spinner variant="primary" v-if="isLoading" />
      <b-form-group v-else>
        <b-input-group prepend="$">
          <b-form-input v-model="form.amount" :min="1" required></b-form-input>
        </b-input-group>
      </b-form-group>
      <div v-if="notExist" class="footer-quote">
        This mover has no earning in their dashboard!
      </div>
      <div class="text-right" v-else>
        <b-spinner variant="primary" v-if="isSubmitting" />
        <b-button v-else type="submit" variant="primary"> Save </b-button>
      </div>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>
<script>
import Toaster from "../../shared/Toaster";
export default {
  name: "Add",
  components: { Toaster },
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
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-center",
          "Warning",
          "All fields are required"
        );
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
<style lang="scss" scoped></style>
