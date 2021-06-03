<template>
  <div>
    <GChart type="LineChart" :data="chartData" :options="chartOptions" />
  </div>
</template>
<script>
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    chartData: [
      ["Month", "Jobs"],
      ["Jan", 1000],
      ["Feb", 1170],
      ["Mar", 1170],
      ["Apr", 1210],
      ["May", 1310],
    ],
    chartOptions: {
      chart: {
        title: "Company Profit",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
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
