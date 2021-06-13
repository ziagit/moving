<template>
  <div>
    <!-- edit dialog -->
    <md-dialog :md-active.sync="dialogTogal">
      <md-dialog-content>
        <SalesFilter v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>
    <md-card>
      <md-card-header
        ><span class="md-title">Sales Reports</span>
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
              <th>Quantity</th>
            </tr>
            <tr>
              <th>{{ currentMonth }}</th>
              <th>{{ orderQty }}</th>
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
            <th>Type</th>
            <th>Order status</th>
            <th>Pickup</th>
            <th>Destination</th>
            <th>Completed at</th>
            <th>Cost</th>
            <th>Customer</th>
            <th>Mover</th>
          </tr>
          <tr v-for="(res, index) in result" :key="index">
            <td>
              <a @click="details(res.id)">{{ res.uniqid }}</a>
            </td>
            <td>{{ res.movingtype.title }}</td>
            <td>{{ res.status }}</td>
            <td>{{ res.addresses[0].city }}</td>
            <td>{{ res.addresses[0].city }}</td>
            <td>{{ dateFormatter(res.updated_at) }}</td>
            <td>{{ res.cost }}</td>
            <td>{{ res.shipper_contacts.first_name }}</td>
            <td>
              {{ res.job_with_carrier.carrier_detail.company }}
            </td>
          </tr>
        </table>
        <Spinner v-else />
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import Spinner from "../../shared/Spinner";
import SalesFilter from "./SalesFilter.vue";
import dateFormatter from "../../frontend/services/dateFormatter";
import axios from "axios";
export default {
  components: {
    Spinner,
    SalesFilter,
  },
  data: () => ({
    result: null,
    orderQty: 0,
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
        .get("admin/sales-reports")
        .then((res) => {
          this.monthName(new Date());
          this.totalOrders(res.data);
          this.result = res.data;
        })
        .catch((err) => console.log(err.response));
    },
    refresh(data) {
      axios
        .post("admin/filter-sales-report", data)
        .then((res) => {
          this.result = res.data;
          this.totalOrders(res.data);
          this.currentMonth = dateFormatter.monthName(
            data.month ? JSON.parse(data.month) : new Date().getMonth() + 1
          );
          this.dialogTogal = false;
        })
        .catch((err) => console.log(err));
    },
    details(id) {
      this.$router.push("/admin/reports/sales-report/" + id);
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
    totalOrders(data) {
      var t = 0;
      for (let i = 0; i < data.length; i++) {
        t = t + 1;
      }
      this.orderQty = t;
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
