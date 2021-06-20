<template>
  <div class="container">
    <div v-if="isLoaded">
      <GChart class="graph" type="PieChart" :data="chartData" :options="chartOptions" />
    </div>
    <div v-else>No data.</div>

    <div class="legend">
      <span class="md-caption">
        <span class="dot" style="background: #4472c4"></span>
        <span>orders received : {{ received }}</span></span
      >
      <span class="md-caption">
        <span class="dot" style="background: #ed7d31"></span>
        <span>orders accepted: {{ accepted }}</span></span
      >
      <span class="md-caption">
        <span class="dot" style="background: #a5a5a5"></span>
        <span>orders declined : {{ declined }}</span></span
      >
      <span class="md-caption">
        <span class="dot" style="background: #ffc000"></span>
        <span>orders compledted {{ completed }}</span></span
      >
      <span class="md-caption">
        <span class="dot" style="background: #5b9bd5"></span>
        <span>orders pending {{ pending }}</span></span
      >
    </div>
  </div>
</template>
<script>
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    isLoaded: false,
    completed: 0,
    canceled: 0,
    accepted: 0,
    declined: 0,
    pending: 0,
    received: 0,

    chartData: [["orders", "Qty"]],
    chartOptions: {
      chart: {
        title: "Company Performance",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
      width: 300,
      height: 300,
      pieHole: 0.65,
      legend: "none",
      chartArea: {
        left: "3%",
        top: "3%",
        height: "600",
        width: "600",
      },
      colors: [],
    },
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/dashboard/daily-projections")
        .then((res) => {
          if (res.data.length > 0) {
            this.feedChart(res.data);
          }
        })
        .catch((err) => console.log(err));
    },
    feedChart(orders) {
      for (let i = 0; i < orders.length; i++) {
        console.log("orders", orders[i]);
        this.received += 1;
        switch (orders[i].status) {
          case "Completed":
            this.completed += 1;
            this.chartData.push(["Completed orders", this.completed]);
            this.chartOptions.colors.push("#FFC000");
            break;
          case "Accepted":
            this.accepted += 1;
            this.chartData.push(["Accepted orders", this.accepted]);
            this.chartOptions.colors.push("#ED7D31");
          case "Declined":
            this.declined += 1;
            this.chartData.push(["Declined orders", this.declined]);
            this.chartOptions.colors.push("#A5A5A5");
          case "Canceled":
            this.chartData.push(["Canceled orders", this.canceled]);
            this.chartOptions.colors.push("#A5A5A5");
          case "New":
            this.chartData.push(["Pending orders", this.pending]);
            this.chartOptions.colors.push("#5B9BD5");
        }
        this.chartData.push(["Received orders", this.received]);
        this.chartOptions.colors.push("#4472C4");
      }
      this.isLoaded = true;
    },
  },
  mounted: function () {},
  components: {
    GChart,
  },
};
</script>

<style scoped lang="scss">
.graph {
  display: flex;
  justify-content: center;
}
.legend {
  margin: 30px 10px;
  display: flex;
  justify-content: center;
  .md-caption {
    margin: 10px;
    display: flex;
    align-items: center;
    .dot {
      height: 10px;
      width: 10px;
      border-radius: 0%;
      display: inline-block;
      margin: 1px;
    }
  }
}
</style>
