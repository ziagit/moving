<template>
  <div class="earnings" v-if="earnings">
    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Unpaid Jobs</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-row>
        <md-table-head md-numeric>Order</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Type</md-table-head>
        <md-table-head>Status</md-table-head>
        <md-table-head>Details</md-table-head>
      </md-table-row>
      <md-table-row v-for="(earning, index) in earnings.data" :key="index">
        <md-table-cell md-numeric>{{ earning.order_detail.uniqid }}</md-table-cell>
        <md-table-cell>{{ formatter(earning.order_detail.created_at) }}</md-table-cell>
        <md-table-cell>{{ earning.order_detail.movingtype.title }}</md-table-cell>
        <md-table-cell>{{ earning.status }}</md-table-cell>
        <md-table-cell>
          <md-button
            class="md-icon-button"
            :to="{ path: 'earning-details/' + earning.id }"
            ><md-icon>more_horiz</md-icon></md-button
          >
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="earnings" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import formatter from "../../frontend/services/dateFormatter";
export default {
  name: "earnings",
  data: () => ({
    keywords: null,
    earnings: null,
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
          console.log("res", res.data.data);
          this.earnings = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/paid-jobs?page=" + page)
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
    formatter(date) {
      return formatter.format(date);
    },

    tCost(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalCost = this.totalCost + data[i].order_detail.cost;
      }
    },
    tPrice(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalPrice = this.totalPrice + data[i].carrier_earning;
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
        this.totalGross = this.totalGross + data[i].tingsapp_earning;
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
  th,
  td {
    text-align: left;
  }
}
</style>
