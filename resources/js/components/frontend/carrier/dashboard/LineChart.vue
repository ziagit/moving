<template>
  <div>
    <div v-if="isLoaded">
      <GChart type="LineChart" :data="chartData" :options="chartOptions" />
    </div>
    <div v-else>No data.</div>
  </div>
</template>
<script>
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    isLoaded: false,
    chartData: [["Month", "($)Revenue"]],
    chartOptions: {
      chart: {
        title: "Company Profit",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
      legend: {
        position: "bottom",
      },
      colors: ["#ffa500"],
      hAxis: {
        textStyle: {
          fontSize: 6, // or the number you want
        },
      },
    },
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("carrier/dashboard/line-chart")
        .then((res) => {
          if (res.data.length > 0) {
            this.feedChart(res.data);
          }
        })
        .catch((err) => console.log(err));
    },
    feedChart(earnings) {
      var jan = 0;
      var feb = 0;
      var mar = 0;
      var apr = 0;
      var may = 0;
      var jun = 0;
      var jul = 0;
      var aug = 0;
      var sep = 0;
      var oct = 0;
      var nov = 0;
      var dec = 0;
      for (let i = 0; i < earnings.length; i++) {
        var month = new Date(earnings[i].created_at).getMonth() + 1;
        switch (month) {
          case 1:
            jan = earnings[i].carrier_earning;
            this.chartData.push(["Jan", jan]);
            break;
          case 2:
            feb = earnings[i].carrier_earning;
            this.chartData.push(["Feb", feb]);
            break;
          case 3:
            mar = earnings[i].carrier_earning;
            this.chartData.push(["Mar", mar]);
            break;
          case 4:
            apr = earnings[i].carrier_earning;
            this.chartData.push(["Apr", apr]);
            break;
          case 5:
            may = earnings[i].carrier_earning;
            this.chartData.push(["May", may]);
            break;
          case 6:
            jun = earnings[i].carrier_earning;
            this.chartData.push(["Jun", jun]);
            break;
          case 7:
            jul = earnings[i].carrier_earning;
            this.chartData.push(["Jul", jul]);
            break;
          case 8:
            aug = earnings[i].carrier_earning;
            this.chartData.push(["Aug", aug]);
            break;
          case 9:
            sep = earnings[i].carrier_earning;
            this.chartData.push(["Sep", sep]);
            break;
          case 10:
            oct = earnings[i].carrier_earning;
            this.chartData.push(["Oct", oct]);
            break;
          case 11:
            nov = earnings[i].carrier_earning;
            this.chartData.push(["Nov", nov]);
          case 12:
            dec = earnings[i].carrier_earning;
            this.chartData.push(["Jan", dec]);
        }
      }
      this.isLoaded = true;
      console.log("cahr data: ", this.chartData);
    },
  },
  mounted: function () {},
  components: {
    GChart,
  },
};
</script>

<style scoped lang="scss">
.container {
  width: 100%;
}
</style>
