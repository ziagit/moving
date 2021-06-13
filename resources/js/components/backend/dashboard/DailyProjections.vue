<template>
  <div>
    <div>
      <GChart type="BubbleChart" :data="chartData" :options="chartOptions" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    isloaded: true,
    cities: [],
    chartData: [
      ["City", "Expected", "Outcome (%)", "Number of placed orders"],
      ["Vancouver", 80.66, 2, "1"],
      ["Victoria", 72.73, 2.6, "2"],
      ["Toronto", 79.84, 1.36, "3"],
      ["Ottawa", 78.6, 1.84, "4"],
    ],
    chartOptions: {
      title: "",
      hAxis: { title: "Expectancy" },
      vAxis: { title: "Fertility Rate" },
      bubble: { textStyle: { fontSize: 9 } },
      height: 500,
      legend: { position: "bottom", alignment: "center" },
      animation: { startup: true },
    },
  }),
  created() {
    this.get();
    this.getCities();
  },
  methods: {
    get() {
      axios.get("admin/dashboard/daily-projections").then((res) => {
        this.feedChart(res.data);
      });
    },
    feedChart(orders) {
      for (let i = 0; i < orders.length; i++) {
        console.log("order", orders[i].addresses[0].city);
        if (orders[i].addresses[0].city == "Vancouver") {
          this.chartData.push(["Vancouver", 80.66, 2, "1"]);
        }
      }
    },
    getCities() {
      axios.get("cities").then((res) => {
        this.cities = res.data;
      });
    },
  },
  components: {
    GChart,
  },
};
</script>

<style scoped lang="scss">
.row {
  display: flex;
  justify-content: space-between;
  .md-card {
    width: 100%;
    text-align: center;
  }
}
</style>
