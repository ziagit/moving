<template>
  <div>
    <table class="table" v-if="orders.length > 0">
      <thead>
        <tr>
          <th>Order</th>
          <th>Date</th>
          <th>Order cost</th>
          <th>Given tips</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(order, index) in orders" :key="index">
          <td>{{ order.uniqid }}</td>
          <td>{{ order.pickup_date }}</td>
          <td>${{ order.cost }}</td>
          <td>${{ order.tips }}</td>
          <td>${{ order.tips + order.cost }}</td>
        </tr>
      </tbody>
    </table>
    <div v-else class="mx-5">
      <p>No payment history!</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "ShipperPaymentDetails",
  components: {},
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
