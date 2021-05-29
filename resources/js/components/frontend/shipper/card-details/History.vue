<template>
  <div class="shipper-card">
    <md-table v-if="orders.length > 0" md-sort="zip" md-sort-order="asc" md-card>
      <md-table-row>
        <md-table-head>Order</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Order cost</md-table-head>
        <md-table-head>Given tips</md-table-head>
        <md-table-head>Total</md-table-head>
      </md-table-row>
      <md-table-row v-for="(order, index) in orders" :key="index">
        <md-table-cell>{{ order.uniqid }}</md-table-cell>
        <md-table-cell>{{ order.pickup_date }}</md-table-cell>
        <md-table-cell>${{ order.cost }}</md-table-cell>
        <md-table-cell>${{ order.tips }}</md-table-cell>
        <md-table-cell>${{ order.tips + order.cost }}</md-table-cell>
      </md-table-row>
    </md-table>
    <md-empty-state
      v-else
      class="md-primary"
      md-icon="sentiment_satisfied_alt"
      md-label="Not available"
      md-description="There is no payment history"
    >
    </md-empty-state>
  </div>
</template>

<script>
import axios from "axios";
import Spinner from "../../../shared/Spinner";
import Snackbar from "../../../shared/Snackbar";
export default {
  name: "ShipperPaymentDetails",
  components: {
    Spinner,
    Snackbar,
  },
  data: () => ({
    orders: [],
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    this.getCharges();
  },
  methods: {
    getCharges() {
      axios
        .get("shipper/charge-details")
        .then((res) => {
          console.log("shipper charges", res.data);
          this.orders = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none !important;
  text-align: left;
}
</style>
