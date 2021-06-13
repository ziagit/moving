<template>
  <div class="payouts" v-if="payouts">
    <md-dialog :md-active.sync="addTogal">
      <md-dialog-title>Create New Payout</md-dialog-title>
      <md-dialog-content>
        <NewPayout v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>
    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <md-button class="md-primary" @click="addTogal = true">New payout</md-button>
        </div>
        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by mover name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-row>
        <md-table-head md-numeric>Mover</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>From</md-table-head>
        <md-table-head>To</md-table-head>
        <md-table-head>Amount</md-table-head>
      </md-table-row>
      <md-table-row v-for="(payout, index) in payouts.data" :key="index">
        <md-table-cell md-numeric>{{ payout.carrier.first_name }}</md-table-cell>
        <md-table-cell>{{ formatter(payout.created_at) }}</md-table-cell>
        <md-table-cell>{{ formatter(payout.from) }}</md-table-cell>
        <md-table-cell>{{ formatter(payout.to) }}</md-table-cell>
        <md-table-cell>${{ payout.amount }}</md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="payouts" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import formatter from "../../frontend/services/dateFormatter";
import NewPayout from "./NewPayout";
export default {
  components: { NewPayout },
  name: "payouts",
  data: () => ({
    keywords: null,
    payouts: null,
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
        .get("admin/search-payout", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("response from payout", res.data.data);
          this.payouts = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/payouts?page=" + page)
        .then((res) => {
          this.payouts = res.data;
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
.payouts {
  width: 100%;
  th,
  td {
    text-align: left;
  }
}
</style>
