<template>
  <div>
    <!-- print invoice -->
    <md-dialog :md-active.sync="printTogal" :md-fullscreen="true">
      <md-dialog-title>Service Provider Invoice</md-dialog-title>
      <md-dialog-content>
        <Invoices v-on:close-dialog="close" :dataToPrint="earnings" />
      </md-dialog-content>
    </md-dialog>
    <md-card md-theme="orange-card">
      <md-card-header>
        <div class="md-title">Earning History</div>
        <!--    <md-button
          @click="print()"
          class="md-icon-button add-btn"
          v-if="earnings.length != 0"
        >
          <md-icon>print</md-icon>
          <md-tooltip>Print invoice</md-tooltip>
        </md-button> -->
      </md-card-header>
      <md-card-content>
        <table class="table" v-if="earnings.length != 0">
          <thead>
            <tr>
              <th rowspan="2">Job</th>
              <th rowspan="2">Company</th>
              <th rowspan="2">From</th>
              <th rowspan="2">To</th>
              <th rowspan="2">Date</th>
              <th colspan="2">Earnings</th>
              <th rowspan="2">Status</th>
              <th rowspan="2">Details</th>
            </tr>
            <tr>
              <th style="font-size: 12px">TingsApp</th>
              <th style="font-size: 12px">Carrier</th>
            </tr>
          </thead>
          <tbody class="body">
            <tr v-for="earning in earnings" :key="earning.id">
              <td>{{ earning.order_address.uniqid }}</td>
              <td>{{ earning.carrier.company }}</td>
              <td>{{ earning.order_address.addresses[0].city }}</td>
              <td>{{ earning.order_address.addresses[1].city }}</td>
              <td>{{ formatter(earning.created_at) }}</td>
              <td>${{ earning.tingsapp_earning }}</td>
              <td>${{ earning.carrier_earning }}</td>
              <td>{{ earning.status == "unpaid" ? "Unpaid" : "Paid" }}</td>

              <td>
                <md-button
                  :to="{ path: 'finance-details/' + earning.id }"
                  class="md-primay md-icon-button"
                >
                  <md-icon>more_horiz</md-icon>
                  <md-tooltip>View more</md-tooltip>
                </md-button>
              </td>
            </tr>
            <tr>
              <th colspan="5">Total</th>
              <th style="color: green">${{ tingsappTotal.toFixed(3) }}</th>
              <th style="color: green">${{ carrierTotal.toFixed(3) }}</th>
              <th colspan="2"></th>
            </tr>
          </tbody>
        </table>
        <md-empty-state
          class="md-primary"
          md-icon="credit_card"
          md-label="$0"
          md-description="List of carrier earning will be showing here"
          v-if="earnings.length == 0"
        ></md-empty-state>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Invoices from "./Invoices";
import axios from "axios";
import functions from "../../frontend/services/functions";
export default {
  name: "earnings",
  data: () => ({
    earnings: [],
    tingsappTotal: 0,
    carrierTotal: 0,
    dataToPrint: null,
    printTogal: false,
  }),
  components: {
    Invoices,
  },
  methods: {
    getearnings() {
      axios
        .get("admin/earnings")
        .then((res) => {
          console.log("res..", res.data);

          this.earnings = res.data;
          this.calculateTotal(res.data);
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    calculateTotal(data) {
      data.forEach((element) => {
        this.tingsappTotal = this.tingsappTotal + element.tingsapp_earning;
        this.carrierTotal = this.carrierTotal + element.carrier_earning;
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
  box-shadow: none;
  border: 1px solid #ddd;
  text-align: center;

  .md-card-content {
    overflow-x: auto;
  }

  .table {
    width: 100%;
    border-collapse: collapse;

    th,
    td {
      border: 1px solid #ddd;
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
</style>
