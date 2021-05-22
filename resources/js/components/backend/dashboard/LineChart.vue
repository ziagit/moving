<template>
  <div>
    <md-card>
      <md-card-header>Customers</md-card-header>
      <md-card-content>
        <GChart type="ColumnChart" :data="chartData" :options="chartOptions" />
      </md-card-content>
    </md-card>
    <br /><br />
    <md-card>
      <md-card-header>Performances</md-card-header>
      <md-card-content>
        <GChart type="PieChart" :data="chartData" :options="chartOptions" />
      </md-card-content>
    </md-card>
    <br /><br />
    <md-card>
      <md-card-header>Revenue</md-card-header>
      <md-card-content>
        <GChart type="LineChart" :data="performanceData" :options="performanceOptions" />
      </md-card-content>
    </md-card>
    <br /><br />
  </div>
</template>

<script>
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    chartData: [
      ["Year", "Movers", "Customers", "Brokers"],
      ["2014", 1000, 400, 200],
      ["2015", 1170, 460, 250],
      ["2016", 660, 1120, 300],
      ["2017", 1030, 540, 350],
      ["2018", 1030, 540, 350],
      ["2019", 1030, 540, 350],
      ["2020", 1030, 540, 350],
    ],
    performanceData: [
      ["Year", "Revenue"],
      ["2014", 1000],
      ["2015", 1170],
      ["2016", 1170],
      ["2017", 1210],
      ["2018", 1310],
      ["2019", 1510],
      ["2020", 2210],
    ],
    chartOptions: {
      chart: {
        title: "Company Performance",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
    },
    performanceOptions: {
      chart: {
        title: "Company Profit",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
    },
  }),
  mounted: function () {},
  components: {
    GChart,
  },
};
</script>

<style scoped lang="scss"></style>
