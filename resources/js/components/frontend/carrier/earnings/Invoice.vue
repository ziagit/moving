<template>
  <div class="invoice" id="printMe">
    <md-card md-theme="orange-card">
      <md-card-content>
        <table class="table" v-if="earnings.length != 0">
          <thead>
            <tr>
              <th rowspan="2">Job</th>
              <th rowspan="2">From</th>
              <th rowspan="2">To</th>
              <th rowspan="2">Date</th>
              <th colspan="5">Charges breakdown</th>
            </tr>
            <tr>
              <th style="font-size: 12px">Distance charges</th>
              <th style="font-size: 12px">Moving charges</th>
              <th style="font-size: 12px">Vehicle charges</th>
              <th colspan="2" style="font-size: 12px">Subtotal</th>
            </tr>
          </thead>
          <tbody class="body">
            <tr v-for="earning in earnings" :key="earning.id">
              <td>{{ earning.order_address.uniqid }}</td>
              <td>{{ earning.order_address.addresses[0].city }}</td>
              <td>{{ earning.order_address.addresses[1].city }}</td>
              <td>{{ formatter(earning.created_at) }}</td>
              <td>${{ earning.distance_charge }}</td>
              <td>${{ earning.moving_charge }}</td>
              <td>${{ earning.vehicle_charge }}</td>
              <td colspan="2">
                ${{
                  earning.distance_charge + earning.moving_charge + earning.vehicle_charge
                }}
              </td>
            </tr>
            <tr>
              <th colspan="7">Total payable amount</th>
              <th colspan="2">${{ total }}</th>
            </tr>
          </tbody>
        </table>
      </md-card-content>
    </md-card>
    <md-button @click="print()" class="md-icon-button print-btn">
      <md-icon>print</md-icon>
      <md-tooltip class="no-print">Print invoice</md-tooltip>
    </md-button>
  </div>
</template>

<script>
import functions from "../../services/functions";
export default {
  name: "Print",
  props: ["dataToPrint"],
  data: () => ({
    total: 0,
    earnings: null,
  }),
  methods: {
    print() {
      window.print();
    },
    calculateTotal() {
      this.earnings.forEach((element) => {
        let subtotal =
          element.distance_charge + element.moving_charge + element.vehicle_charge;
        this.total = this.total + subtotal;
      });
    },
    formatter(date) {
      return functions.myDateFormat(date);
    },
  },
  created() {
    this.earnings = this.dataToPrint;
    this.calculateTotal();
  },
};
</script>

<style lang="scss" scoped>
.invoice {
  min-height: 700px;
}
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
  }
}
.print-btn {
  position: absolute;
  bottom: 0;
  right: 0;
}
@media print {
  .print-btn,
  .no-print {
    display: none;
  }
}
</style>
