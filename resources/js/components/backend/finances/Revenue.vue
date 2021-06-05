<template>
  <div class="earnings" v-if="earnings">
    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Eanings</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-row>
        <md-table-head md-numeric>Order</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Price</md-table-head>
        <md-table-head>Cost</md-table-head>
        <md-table-head>GST Received</md-table-head>
        <md-table-head>GST Paid</md-table-head>
        <md-table-head>Owing GST</md-table-head>
        <md-table-head>Gross Profit</md-table-head>
      </md-table-row>
      <md-table-row v-for="(earning, index) in earnings.data" :key="index">
        <md-table-cell md-numeric>{{ earning.order.uniqid }}</md-table-cell>
        <md-table-cell>{{ earning.order.created_at }}</md-table-cell>
        <md-table-cell>${{ earning.order.cost }}</md-table-cell>
        <md-table-cell>${{ earning.order.cost }}</md-table-cell>
        <md-table-cell>${{ earning.received_gst }}</md-table-cell>
        <md-table-cell>${{ earning.paid_gst }}</md-table-cell>
        <md-table-cell>${{ earning.unpaid_gst }}</md-table-cell>
        <md-table-cell>${{ earning.order.cost }}</md-table-cell>
      </md-table-row>
      <md-table-row>
        <md-table-cell></md-table-cell>
        <md-table-cell>Total</md-table-cell>
        <md-table-cell>${{ Math.round(totalCost).toFixed(2) }}</md-table-cell>
        <md-table-cell>${{ Math.round(totalPrice).toFixed(2) }}</md-table-cell>
        <md-table-cell>${{ Math.round(totalReceived).toFixed(2) }}</md-table-cell>
        <md-table-cell>${{ Math.round(totalPaid).toFixed(2) }}</md-table-cell>
        <md-table-cell>${{ Math.round(totalOwing).toFixed(2) }}</md-table-cell>
        <md-table-cell>${{ Math.round(totalGross).toFixed(2) }}</md-table-cell>
      </md-table-row>
    </md-table>

    <pagination :limit="4" :data="earnings" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
export default {
  name: "earnings",
  data: () => ({
    keywords: null,
    earnings: null,
    total: 0,
    totalCost: 0,
    totalPrice: 0,
    totalReceived: 0,
    totalPaid: 0,
    totalOwing: 0,
    totalGross: 0,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },

  methods: {
    search() {
      axios
        .get("admin/search-earning", { params: { keywords: this.keywords } })
        .then((res) => {
          this.earnings = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/earnings?page=" + page)
        .then((res) => {
          this.earnings = res.data;
          console.log("res.data", res.data.data);
          this.tCost(res.data.data);
          this.tPrice(res.data.data);
          this.tReceived(res.data.data);
          this.tPaid(res.data.data);
          this.tOwing(res.data.data);
          this.tGross(res.data.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    tCost(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalCost = this.totalCost + data[i].order.cost;
      }
    },
    tPrice(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalPrice = this.totalPrice + data[i].order.cost;
      }
    },
    tReceived(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalReceived = this.totalReceived + data[i].received_gst;
      }
    },
    tPaid(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalPaid = this.totalPaid + data[i].paid_gst;
      }
    },
    tOwing(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalOwing = this.totalOwing + data[i].unpaid_gst;
      }
    },
    tGross(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalGross = this.totalGross + data[i].order.cost;
      }
    },
  },
  created() {
    this.get();
  },
};
</script>
<style scoped lang="scss">
.earnings {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
  .unlocked {
    color: #25c925;
  }
  .locked {
    color: red;
  }
  table {
    width: 100%;
    tr {
      td {
        text-align: center;
      }
    }
  }
}
</style>
