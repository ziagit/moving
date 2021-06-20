<template>
  <b-card class="border-0 shadow text-left" header="Orders">
    <table class="table" v-if="orders.length > 0">
      <thead>
        <tr>
          <th>Order</th>
          <th>Pickup</th>
          <th>Destination</th>
          <th>Date</th>
          <th>Time</th>
          <th>Cost</th>
          <th>Status</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.uniqid }}</td>
          <td>{{ order.addresses[0].city }}</td>
          <td>{{ order.addresses[1].city }}</td>
          <td>{{ order.pickup_date }}</td>
          <td>{{ order.appointment_time }}</td>
          <td>${{ order.cost }}</td>
          <td>{{ order.status }}</td>

          <td>
            <b-button :to="{ path: 'details/' + order.id }" variant="light">
              <b-icon icon="three-dots">more_horiz</b-icon>
            </b-button>
          </td>
        </tr>
      </tbody>
    </table>
  </b-card>
</template>

<script>
import axios from "axios";
import functions from "../../services/functions";
export default {
  name: "ShipperOrders",
  data: () => ({
    orders: [],
    tempOrder: null,
  }),
  methods: {
    get() {
      axios
        .get("shipper/orders")
        .then((res) => {
          console.log("shipper order ", res.data);
          this.orders = res.data;
        })
        .catch((err) => console.log(err));
    },
    processOrder() {
      this.$router.push(localStorage.getItem("cRoute"));
    },
    removeOrder() {
      localStorage.removeItem("order");
      this.tempOrder = null;
    },
  },
  created() {
    this.get();
    this.tempOrder = JSON.parse(localStorage.getItem("order"));
  },
};
</script>

<style lang="scss" scoped>
@media only screen and (max-width: 600px) {
}
</style>
