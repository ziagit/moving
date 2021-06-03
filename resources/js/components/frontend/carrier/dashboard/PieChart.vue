<template>
  <div>
    <GChart
      type="PieChart"
      :resizeDebounce="500"
      :data="chartData"
      :options="chartOptions"
    />
  </div>
</template>
<script>
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    chartData: [
      ["Jobs", "Number"],
      ["Received jobs", 3],
      ["Accepted jobs", 1],
      ["Declined jobs", 1],
      ["Completed jobs", 1],
      ["Pending jobs", 2],
    ],
    chartOptions: {
      chart: {
        title: "Company Performance",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
        width: 800,
        height: 600,
        pieHole: 0.6,
      },
    },
  }),
  created() {},
  methods: {},
  mounted: function () {},
  components: {
    GChart,
  },
};
</script>

<style scoped lang="scss"></style>
