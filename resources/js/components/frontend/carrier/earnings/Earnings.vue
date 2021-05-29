<template>
  <div>
    <md-card>
      <md-card-header>
        <span class="md-title">Earning History</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <table class="table" v-if="earnings.length > 0">
          <thead>
            <tr>
              <th rowspan="2">Job</th>
              <th rowspan="2">From</th>
              <th rowspan="2">To</th>
              <th rowspan="2">Date</th>
              <th colspan="6">Charges breakdown</th>
              <th rowspan="2">Status</th>
            </tr>
            <tr>
              <th style="font-size: 12px">Travel Cost</th>
              <th style="font-size: 12px">Moving Cost</th>
              <th style="font-size: 12px">Supplies Cost</th>
              <th style="font-size: 12px">Service Fee</th>

              <th style="font-size: 12px">Tax</th>
              <th style="font-size: 12px">Subtotal</th>
            </tr>
          </thead>
          <tbody class="body">
            <tr v-for="earning in earnings" :key="earning.id">
              <td>{{ earning.order_address.uniqid }}</td>
              <td>{{ earning.order_address.addresses[0].city }}</td>
              <td>{{ earning.order_address.addresses[1].city }}</td>
              <td>{{ formatter(earning.created_at) }}</td>
              <td>${{ earning.travel_cost }}</td>
              <td>${{ earning.moving_cost }}</td>
              <td>${{ earning.supplies_cost }}</td>
              <td>-${{ earning.service_fee }}</td>

              <td>${{ earning.paid_gst }}</td>
              <td>${{ earning.carrier_earning }}</td>

              <td>{{ earning.status == "unpaid" ? "Unpaid" : "Paid" }}</td>
            </tr>
            <tr>
              <th colspan="9">Total Payable Amount</th>
              <th style="color: green">${{ total.toFixed(3) }}</th>
              <th></th>
            </tr>
          </tbody>
        </table>
        <md-empty-state
          class="md-primary"
          md-icon="credit_card"
          md-label="$0"
          md-description="When you complete a job, your earning will be showing here"
          v-if="earnings.length == 0"
        ></md-empty-state>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Invoice from "./Invoice";
import axios from "axios";
import functions from "../../services/functions";
export default {
  name: "earnings",
  data: () => ({
    earnings: [],
    total: 0,
    dataToPrint: null,
    printTogal: false,
  }),
  components: {
    Invoice,
  },
  methods: {
    getearnings() {
      axios
        .get("carrier/earnings")
        .then((res) => {
          this.earnings = res.data;
          console.log("res..", res.data);
          this.calculateTotal(res.data);
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    calculateTotal(data) {
      data.forEach((element) => {
        this.total = this.total + element.carrier_earning;
      });
    },
    print() {
      this.printTogal = true;
    },
    close() {
      this.printTogal = false;
    },
    formatter(date) {
      return functions.myDateFormat(date);
    },
  },
  created() {
    this.getearnings();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .table {
    width: 100%;
    border-collapse: collapse;
    overflow: auto;

    th,
    td {
      border: 1px solid #ddd;
      text-align: center;
    }
    .body {
      tr {
        td {
          font-size: 12px;
        }
      }
    }
    .delivered {
      color: green !important;
    }
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
.note {
  text-align: left;
  .md-body-2 {
    color: #ffa500;
  }
}
@media only screen and (max-width: 1150px) {
  .table {
    overflow-x: auto;
  }
}
</style>
