<template>
  <div class="refunds" v-if="refunds">
    <md-dialog :md-active.sync="addTogal">
      <md-dialog-title>Create new refund</md-dialog-title>
      <md-dialog-content>
        <NewRefund v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>
    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <md-button class="md-primary" @click="addTogal = true">New refund</md-button>
        </div>
        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by mover name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-row>
        <md-table-head md-numeric>#</md-table-head>
        <md-table-head>Customer</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Amount</md-table-head>
      </md-table-row>
      <md-table-row v-for="(refund, index) in refunds.data" :key="index">
        <md-table-cell>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ refund.shipper.first_name }}</md-table-cell>
        <md-table-cell>{{ formatter(refund.created_at) }}</md-table-cell>
        <md-table-cell>${{ refund.amount }}</md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="refunds" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import formatter from "../../frontend/services/dateFormatter";
import NewRefund from "./NewRefund";
export default {
  components: { NewRefund },
  name: "refunds",
  data: () => ({
    keywords: null,
    refunds: null,
    totalCost: 0,
    totalPrice: 0,
    totalReceived: 0,
    totalPaid: 0,
    totalOwing: 0,
    totalGross: 0,
    addTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },

  methods: {
    search() {
      axios
        .get("admin/search-refund", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("res", res.data.data);
          this.refunds = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/refunds?page=" + page)
        .then((res) => {
          this.refunds = res.data;
          console.log("res.data", res.data.data);
          this.tCost(res.data.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    formatter(date) {
      return formatter.format(date);
    },

    tCost(data) {
      /* for (let i = 0; i < data.length; i++) {
        this.totalCost = this.totalCost + data[i].order.cost;
      } */
    },

    refresh() {
      this.addTogal = false;
      this.get();
    },
  },
  created() {
    this.get();
  },
};
</script>
<style scoped lang="scss">
.refunds {
  width: 100%;
  th,
  td {
    text-align: left;
  }
}
</style>
