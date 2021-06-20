<template>
  <div class="container">
    <b-modal id="modal-filter" size="md" title="Filter By" :hide-footer="true">
      <FinancialFilter v-on:close-dialog="refresh" />
    </b-modal>
    <b-card class="mt-5 mb-5 border-0 shadow" header="Financial Reports">
      <div class="no-print">
        <b-button variant="light" v-b-modal.modal-filter
          ><b-icon variant="primary" icon="filter-left"></b-icon
        ></b-button>
        <b-button variant="light" @click="printIt()"
          ><b-icon icon="printer" variant="primary"></b-icon
        ></b-button>
        <b-button variant="light" @click="download()"
          ><b-icon icon="download" variant="primary"></b-icon
        ></b-button>
      </div>
      <md-card-content>
        <div class="row mr-0">
          <div class="col-8"></div>
          <table class="col-4">
            <tr>
              <th>Total gross profit</th>
            </tr>
            <tr>
              <th>${{ totalGross }}</th>
            </tr>
          </table>
        </div>
        <div class="break"></div>
        <table v-if="result">
          <tr>
            <th>Order</th>
            <th>Date</th>
            <th>Received amount</th>
            <th>Payout amount</th>
            <th>Recevied GST</th>
            <th>Paid GST</th>
            <th>Unpaid GST</th>
            <th>Status</th>
            <th>Gross profit</th>
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
        <b-spinner v-else />
      </md-card-content>
    </b-card>
  </div>
</template>
<script>
import FinancialFilter from "./FinancialFilter.vue";
import dateFormatter from "../../frontend/services/dateFormatter";
import axios from "axios";
export default {
  components: {
    FinancialFilter,
  },
  data: () => ({
    result: null,
    totalGross: 0,
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
          this.$bvModal.hide("modal-filter");
          this.totalAmount(res.data);
          this.result = res.data;
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
      this.totalGross = t;
    },
  },
};
</script>
<style scoped lang="scss">
.container {
  min-height: calc(100vh - 50px);
  .no-print {
    position: absolute;
    top: 0;
    right: 0;
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
}
</style>
