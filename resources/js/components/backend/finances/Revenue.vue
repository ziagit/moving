<template>
  <div class="container" v-if="earnings">
    <b-card header="Revenues" class="border-0 shadow mt-5">
      <div class="d-flex justify-content-between align-items-center">
        <span class="w-25"
          ><b>Total Revenue: ${{ total }}</b></span
        >
        <b-form-input placeholder="Search by order..." v-model="keywords" />
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Order</th>
            <th>Date</th>
            <th>Price</th>
            <th>Cost</th>
            <th>GST Received</th>
            <th>GST Paid</th>
            <th>Owing GST</th>
            <th>Gross Profit</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(earning, index) in earnings.data" :key="index">
            <td>{{ earning.order.uniqid }}</td>
            <td>{{ formatter(earning.order.created_at) }}</td>
            <td>${{ earning.carrier_earning }}</td>
            <td>${{ earning.order.cost }}</td>
            <td>${{ earning.received_gst }}</td>
            <td>${{ earning.paid_gst }}</td>
            <td>${{ earning.unpaid_gst }}</td>
            <td>${{ earning.tingsapp_earning }}</td>
          </tr>
          <tr>
            <td></td>
            <td><b>Total</b></td>
            <td>
              <b>${{ Math.round(totalCost).toFixed(2) }}</b>
            </td>
            <td>
              <b>${{ Math.round(totalPrice).toFixed(2) }}</b>
            </td>
            <td>
              <b>${{ Math.round(totalReceived).toFixed(2) }}</b>
            </td>
            <td>
              <b>${{ Math.round(totalPaid).toFixed(2) }}</b>
            </td>
            <td>
              <b>${{ Math.round(totalOwing).toFixed(2) }}</b>
            </td>
            <td>
              <b>${{ Math.round(totalGross).toFixed(2) }}</b>
            </td>
          </tr>
        </tbody>
      </table>
    </b-card>

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
          console.log("res", res.data.data);
          this.earnings = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/revenue?page=" + page)
        .then((res) => {
          this.earnings = res.data;
          console.log("res.data", res.data.data);
          this.totalRevenue(res.data.data);
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
    totalRevenue(data) {
      for (let i = 0; i < data.length; i++) {
        this.total = this.total + data[i].order.cost;
      }
    },
    tCost(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalCost = this.totalCost + data[i].order.cost;
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
.container {
  min-height: calc(100vh - 50px);
}
</style>
