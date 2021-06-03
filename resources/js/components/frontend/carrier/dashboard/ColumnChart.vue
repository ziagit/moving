<template>
  <div>
    <GChart type="ColumnChart" :data="chartData" :options="chartOptions" />
  </div>
</template>
<script>
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    chartData: [
      ["Month", "Nubmer of jobs"],
      ["Jan", 0],
      ["Feb", 10],
      ["Mar", 20],
      ["Apr", 30],
      ["May", 40],
      ["Jun", 50],
      ["Jul", 60],
      ["Sep", 30],
      ["Oct", 80],
      ["Nov", 10],
      ["Dec", 100],
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
