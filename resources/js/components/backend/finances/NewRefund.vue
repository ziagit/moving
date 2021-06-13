<template>
  <div>
    <form @submit.prevent="submit">
      <md-field class="order-field">
        <label>Order id</label>
        <md-input v-model="keywords" required></md-input>
      </md-field>
      <ul v-if="searchTogal">
        <li v-for="refund in refunds" :key="refund.id" @click="select(refund)">
          {{ refund.uniqid }}
        </li>
      </ul>
      <ul v-if="notFoundTogal">
        <li>Not found</li>
      </ul>
      <md-field>
        <label>Customer</label>
        <md-input v-model="form.shipper" required></md-input>
      </md-field>
      <md-field>
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
import axios from "axios";
import Snackbar from "../../shared/Snackbar";
import Spinner from "../../shared/Spinner";
export default {
  name: "Add",
  components: { Spinner, Snackbar },
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
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
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
        this.snackbar.message = "All fields are required";
        this.snackbar.statusCode = "409";
        this.snackbar.show = true;
      } else {
        this.isSubmitting = true;
        axios.post("admin/refunds", this.form).then((res) => {
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
form {
  position: relative;
}
.submit {
  text-align: right;
}

ul {
  box-shadow: 1px 1px 1px 0px;
  position: absolute;
  width: 100%;
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
