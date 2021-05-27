<template>
  <div>
    <md-card>
      <md-card-header>
        <div class="md-title">Orders</div>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
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
              <td>{{ order.cost }}</td>
              <td>{{ order.status }}</td>

              <td>
                <md-button
                  :to="{ path: 'details/' + order.id }"
                  class="md-primay md-icon-button"
                >
                  <md-icon>more_horiz</md-icon>
                  <md-tooltip>View more</md-tooltip>
                </md-button>
              </td>
            </tr>
          </tbody>
        </table>
        <md-empty-state
          v-else
          class="md-primary"
          md-icon="sentiment_satisfied_alt"
          md-label="Not available"
          md-description="Click + icon to get a new quote"
        >
          <md-button to="/" class="md-icon-button md-raised">
            <md-icon>add</md-icon>
            <md-tooltip>Get a free order quotation</md-tooltip>
          </md-button>
        </md-empty-state>
      </md-card-content>
    </md-card>
  </div>
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
.md-card {
  text-align: left;
  .table {
    width: 100%;
    border-collapse: collapse;

    th,
    td {
      border: 1px solid #ddd;
      text-align: center;
    }

    .delivered {
      color: green !important;
    }
  }
}

@media only screen and (max-width: 600px) {
  .shipper-orders {
    .md-card {
      overflow: auto !important;
    }
  }
}
</style>
