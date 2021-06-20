<template>
  <div>
    <form @submit.prevent="submit">
      <b-form-group>
        <b-form-input v-model="keywords" required placeholder="Order id"></b-form-input>
      </b-form-group>
      <ul v-if="searchTogal">
        <li v-for="refund in refunds" :key="refund.id" @click="select(refund)">
          {{ refund.uniqid }}
        </li>
      </ul>
      <ul v-if="notFoundTogal">
        <li>Not found</li>
      </ul>
      <b-form-group>
        <b-form-input
          v-model="form.shipper"
          required
          placeholder="Customer"
        ></b-form-input>
      </b-form-group>
      <b-form-group>
        <b-input-group prepend="$">
          <b-form-input
            v-model="form.amount"
            :min="1"
            required
            class="Amount"
          ></b-form-input>
        </b-input-group>
      </b-form-group>
      <div v-if="notExist">This mover has no earning in their dashboard!</div>
      <div class="text-right" v-else>
        <b-spinner v-if="isSubmitting" variant="primary" />
        <b-button v-else type="submit" variant="primary"> Submit </b-button>
      </div>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>
<script>
import axios from "axios";
import Toaster from "../../shared/Toaster";
export default {
  name: "NewRefund",
  components: { Toaster },
  data: () => ({
    refunds: [],
    searchTogal: false,
    notFoundTogal: false,
    keywords: null,
    shipper: null,
    form: {
      shipper: null,
      shipper_id: null,
      amount: null,
      order: null,
    },
    isSubmitting: false,
    isLoading: false,
    notExist: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  created() {
    this.get();
  },
  methods: {
    search() {
      axios
        .get("admin/search-refund", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("res", res.data.data);
          if (res.data.data.length < 0) {
            this.notFoundTogal = true;
            this.searchTogal = false;
          } else {
            this.searchTogal = true;
            this.refunds = res.data.data;
            this.notFoundTogal = false;
            this.$refs.toaster;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    select(selected) {
      this.searchTogal = false;
      this.keywords = selected.uniqid;
      axios.get("admin/refunds/" + selected.uniqid).then((res) => {
        this.form.order = res.data.uniqid;
        this.form.amount = res.data.cost;
        this.form.shipper = res.data.shipper.id;
        this.form.shipper = res.data.shipper.first_name;
        this.form.shipper_id = res.data.shipper.id;
        console.log("res ", res.data);
      });
    },
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
        this.form.shipper == null ||
        this.form.amount == null ||
        this.form.order == null
      ) {
        this.$refs.toaster.show(
          "success",
          "b-toaster-top-center",
          "Invalid Data",
          "All fields are required!"
        );
      } else {
        this.isSubmitting = true;
        axios
          .post("admin/refunds", this.form)
          .then((res) => {
            console.log("res", res.data);
            this.isSubmitting = false;
            this.$emit("close-dialog", res.data);
          })
          .catch((err) => {
            this.$emit("close-dialog", err.response);
          });
      }
    },
  },
};
</script>
<style lang="scss" scoped>
ul {
  box-shadow: 1px 1px 1px 0px;
  position: absolute;
  width: 90%;
  background: #fff;
  z-index: 99;
  margin: -24px 0 0 0;
  padding: 0;
  li {
    list-style-type: none;
    cursor: pointer;
    padding: 2px;
  }
  li:hover {
    background: #ddd;
  }
}
</style>
