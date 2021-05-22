<template>
  <div class="shipper-card">
    <md-table md-sort="zip" md-sort-order="asc" md-card>
      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()"
          >Create new address</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head>Order</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Amount</md-table-head>
      </md-table-row>
      <md-table-row v-for="(order, index) in orders" :key="index">
        <md-table-cell>{{ order.uniqid }}</md-table-cell>
        <md-table-cell>{{ order.pickup_date }}</md-table-cell>
        <md-table-cell>{{ order.cost }}</md-table-cell>
      </md-table-row>
    </md-table>
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
    orders: null,
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
