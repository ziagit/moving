<template>
  <div>
    <md-table md-sort="zip" md-sort-order="asc" md-card>
      <!--       <md-table-toolbar>
        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by order id" v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
      </md-table-empty-state> -->

      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Order</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Type</md-table-head>
        <md-table-head>Price</md-table-head>
        <md-table-head>Status</md-table-head>
        <md-table-head>Details</md-table-head>
      </md-table-row>
      <md-table-row v-for="(earning, index) in earnings.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ earning.order_address.uniqid }}</md-table-cell>
        <md-table-cell>{{ formatter(earning.created_at) }}</md-table-cell>
        <md-table-cell>{{ earning.order_address.movingtype_id }}</md-table-cell>
        <md-table-cell>${{ earning.carrier_earning }}</md-table-cell>
        <md-table-cell>{{ earning.status }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="details(earning.id)">
            <md-icon>more_horiz</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <div class="total">
      <strong>Total collected amount: ${{ total }}</strong>
    </div>
  </div>
</template>

<script>
import formatter from "../../services/dateFormatter";
export default {
  name: "Unpaid",
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
        .get("carrier/paid?page=" + page)
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
