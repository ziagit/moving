<template>
  <div class="container" v-if="earnings">
    <b-card header="Unpaid Jobs" class="border-0 shadow mt-5">
      <b-form-input placeholder="Search by order..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>Order</th>
            <th>Date</th>
            <th>Type</th>
            <th>Status</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(earning, index) in earnings.data" :key="index">
            <td md-numeric>{{ earning.order_detail.uniqid }}</td>
            <td>{{ formatter(earning.order_detail.created_at) }}</td>
            <td>{{ earning.order_detail.movingtype.title }}</td>
            <td>{{ earning.status }}</td>
            <td>
              <b-button variant="light" @click="details(earning.id)"
                ><b-icon variant="primary" icon="three-dots"></b-icon
              ></b-button>
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
        .get("admin/unpaid-jobs?page=" + page)
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
    details(id) {
      this.$router.push("earning-details/" + id);
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
