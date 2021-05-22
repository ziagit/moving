<template>
  <div class="shipper-orders">
    <md-card class="no-shadow-bordered">
      <md-card-header>
        <div class="md-title md-primary">Orders</div>
        <md-button to="/home" class="md-icon-button close-btn">
          <md-icon>add</md-icon>
          <md-tooltip>Create a new order</md-tooltip>
        </md-button>
      </md-card-header>
      <md-card-content>
        <div v-if="tempOrder" class="temp-order">
          <div>
            <span>You have an new order in process</span>
            <md-button @click="processOrder()">
              Process
              <md-tooltip>Process your order</md-tooltip>
            </md-button>
          </div>
          <md-button @click="removeOrder()" class="md-icon-button btn-close">
            <md-icon>close</md-icon>
            <md-tooltip>Remove order</md-tooltip>
          </md-button>
        </div>
        <table class="table" v-if="orders">
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
            <md-tooltip>Get a free quote</md-tooltip>
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
    orders: null,
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
.shipper-orders {
  .md-card {
    text-align: center;
    overflow: auto;
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

    .temp-order {
      background: #e7ecf3;
      border-radius: 5px;
      padding-left: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;

      div {
        display: flex;
        align-items: center;
      }
    }

    .close-btn {
      position: absolute;
      top: 0;
      right: 0;
    }
  }
}
</style>
