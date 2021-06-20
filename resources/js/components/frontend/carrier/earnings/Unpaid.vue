<template>
  <div>
    <table class="table text-left">
      <tr>
        <th>Order</th>
        <th>Date</th>
        <th>Type</th>
        <th>Price</th>
        <th>Status</th>
        <th>Details</th>
      </tr>
      <tr v-for="(earning, index) in earnings.data" :key="index">
        <td>{{ earning.order.uniqid }}</td>
        <td>{{ formatter(earning.created_at) }}</td>
        <td>{{ earning.order.movingtype_id }}</td>
        <td>${{ earning.carrier_earning }}</td>
        <td>{{ earning.status }}</td>

        <td md-label="Actions">
          <b-button variant="light" @click="details(earning.id)">
            <b-icon icon="three-dots"></b-icon>
          </b-button>
        </td>
      </tr>

      <tr>
        <td></td>
        <td></td>
        <td><b>Balance</b></td>
        <td>
          <b>${{ total }}</b>
        </td>
        <td></td>
        <td></td>
      </tr>
    </table>
  </div>
</template>

<script>
import formatter from "../../services/dateFormatter";
export default {
  name: "Paid",
  data: () => ({
    earnings: [],
    keywords: null,
    total: 0,
    dataToPrint: null,
    printTogal: false,
  }),
  components: {},
  methods: {
    get(page = 1) {
      axios
        .get("carrier/unpaid?page=" + page)
        .then((res) => {
          this.earnings = res.data;
          console.log("res..", res.data.data);
          this.calculateTotal(res.data.data);
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    calculateTotal(data) {
      data.forEach((element) => {
        this.total = this.total + element.carrier_earning;
      });
    },
    details(id) {
      this.$router.push("details/" + id);
    },
    formatter(date) {
      return formatter.format(date);
    },
  },
  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none !important;
}
.total {
  text-align: right;
}
@media only screen and (max-width: 1150px) {
}
</style>
