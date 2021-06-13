<template>
  <div>
    <!-- edit dialog -->
    <md-dialog :md-active.sync="dialogTogal">
      <md-dialog-content>
        <FinancialFilter v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>
    <md-card>
      <md-card-header
        ><span class="md-title">Financial Reports</span>
        <div class="no-print">
          <md-button class="md-icon-button md-primary" @click="dialogTogal = true"
            ><md-icon class="md-primary">sort</md-icon></md-button
          >
          <md-button class="md-icon-button md-primary" @click="printIt()"
            ><md-icon class="md-primary">print</md-icon></md-button
          >
        </div>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="total">
          <div></div>
          <table>
            <tr>
              <th>Month</th>
              <th>Total net profit</th>
            </tr>
            <tr>
              <th>{{ currentMonth }}</th>
              <th>${{ totalIncome }}</th>
            </tr>
          </table>
        </div>
        <div class="break"></div>
        <table v-if="result">
          <tr>
            <th>Month</th>
            <th colspan="8">{{ currentMonth }}</th>
          </tr>
          <tr>
            <th>Order</th>
            <th>Date</th>
            <th>Received amount</th>
            <th>Payout amount</th>
            <th>Recevied GST</th>
            <th>Paid GST</th>
            <th>Unpaid GST</th>
            <th>Status</th>
            <th>Net profit</th>
          </tr>
          <tr v-for="(res, index) in result" :key="index">
            <td>
              <a @click="details(res.id)">{{ res.order.uniqid }}</a>
            </td>
            <td>${{ dateFormatter(res.updated_at) }}</td>
            <td>${{ res.order.cost }}</td>
            <td>${{ res.carrier_earning }}</td>
            <td>${{ res.received_gst }}</td>
            <td>${{ res.paid_gst }}</td>
            <td>${{ res.unpaid_gst }}</td>
            <td>{{ res.status }}</td>
            <td>${{ res.tingsapp_earning }}</td>
          </tr>
        </table>
        <Spinner v-else />
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import Spinner from "../../shared/Spinner";
import FinancialFilter from "./FinancialFilter.vue";
import dateFormatter from "../../frontend/services/dateFormatter";
import axios from "axios";
export default {
  components: {
    Spinner,
    FinancialFilter,
  },
  data: () => ({
    result: null,
    totalIncome: 0,
    filterTogal: false,
    dialogTogal: false,
    currentMonth: null,
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/financial-reports")
        .then((res) => {
          console.log("result: ", res.data);
          this.result = res.data;
          this.totalAmount(res.data);
          this.monthName(new Date());
        })
        .catch((err) => console.log(err.response));
    },
    refresh(data) {
      if (data.month) {
        console.log(data.month);
      }
      axios
        .post("admin/filter-financial-report", data)
        .then((res) => {
          this.totalAmount(res.data);
          this.currentMonth = dateFormatter.monthName(
            data.month ? JSON.parse(data.month) : new Date().getMonth() + 1
          );
          this.result = res.data;
          this.dialogTogal = false;
        })
        .catch((err) => console.log(err));
    },
    details(id) {
      this.$router.push("/admin/reports/financial-report/" + id);
    },
    dateFormatter(date) {
      return dateFormatter.format(date);
    },
    printIt() {
      window.print();
    },
    monthName(d) {
      this.currentMonth = dateFormatter.monthName(d.getMonth() + 1);
    },
    totalAmount(data) {
      var t = 0;
      for (let i = 0; i < data.length; i++) {
        t = t + data[i].tingsapp_earning;
      }
      this.totalIncome = t;
    },
  },
};
</script>
<style scoped lang="scss">
.md-card-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}
.md-card-content {
  .total {
    display: flex;
    justify-content: space-between;
    table {
      max-width: 200px;
    }
  }
}

table {
  width: 100%;
  border: 1px solid #ddd;
  border-collapse: collapse;
  tr {
    border: 1px solid #ddd;
    td,
    th {
      border: 1px solid #ddd;
      text-align: left;
      padding: 5px;
    }
    td {
      font-size: 12px;
    }
  }
}
</style>
