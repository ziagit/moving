<template>
  <div>
    <div v-if="isLoaded" class="text-center">
      <GChart class="graph" type="PieChart" :data="chartData" :options="chartOptions" />
    </div>
    <div v-else>No data.</div>
    <div class="legend mt-3 mb-3">
      <span class="caption">
        <span class="dot" style="background: #4472c4"></span>
        <span>Jobs received : {{ received }}</span></span
      >
      <span class="caption">
        <span class="dot" style="background: #ed7d31"></span>
        <span>Jobs accepted: {{ accepted }}</span></span
      >
      <span class="caption">
        <span class="dot" style="background: #a5a5a5"></span>
        <span>Jobs declined : {{ declined }}</span></span
      >
      <span class="caption">
        <span class="dot" style="background: #ffc000"></span>
        <span>Jobs compledted {{ completed }}</span></span
      >
      <span class="caption">
        <span class="dot" style="background: #5b9bd5"></span>
        <span>Jobs pending {{ pending }}</span></span
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
    chartData: [
      ["Jobs", "Qty"],
      ["Completed", 20],
    ],
    chartOptions: {
      chart: {
        title: "Company Performance",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
      width: "300",
      height: "300",
      pieHole: 0.65,
      legend: "none",
      colors: ["#0598d8", "#f97263"],
      chartArea: {
        left: "3%",
        top: "3%",
        height: "600",
        width: "600",
      },
    },
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("carrier/dashboard/pie-chart")
        .then((res) => {
          if (res.data.length > 0) {
            this.feedChart(res.data);
          }
        })
        .catch((err) => console.log(err));
    },
    feedChart(jobs) {
      for (let i = 0; i < jobs.length; i++) {
        this.received += 1;
        switch (jobs[i].order.status) {
          case "Completed":
            this.completed += 1;
            this.chartData.push(["Completed jobs", this.completed]);
            this.chartOptions.colors.push("#FFC000");
            break;
          case "Accepted":
            this.accepted += 1;
            this.chartData.push(["Accepted jobs", this.accepted]);
            this.chartOptions.colors.push("#ED7D31");
          case "Declined":
            this.declined += 1;
            this.chartData.push(["Declined jobs", this.declined]);
            this.chartOptions.colors.push("#A5A5A5");
          case "Canceled":
            this.chartData.push(["Canceled jobs", this.canceled]);
            this.chartOptions.colors.push("#A5A5A5");
          case "New":
            this.chartData.push(["Pending jobs", this.pending]);
            this.chartOptions.colors.push("#5B9BD5");
        }
      }
      this.chartData.push(["Received jobs", this.received]);
      this.chartOptions.colors.push("#4472C4");
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
  .caption {
    margin: 10px;
    display: flex;
    align-items: center;
    .dot {
      height: 8px;
      width: 8px;
      border-radius: 0%;
      display: inline-block;
      margin: 1px;
    }
    span {
      font-size: 11px;
    }
  }
}
</style>
