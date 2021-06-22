<template>
  <div>
    <div v-if="isLoaded">
      <GChart
        type="AreaChart"
        :resizeDebounce="500"
        :data="chartData"
        :options="chartOptions"
      />
    </div>
    <div v-else>No data.</div>
  </div>
</template>
<script>
import axios from "axios";
import { GChart } from "vue-google-charts";
export default {
  data: () => ({
    isLoaded: false,
    chartData: [["Year", "Sales", "Expenses"]],
    chartOptions: {
      chart: {
        title: "Company Performance",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
      legend: { position: "bottom", alignment: "center" },
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
      axios.get("admin/dashboard/performance").then((res) => {
        if (res.data.length > 0) {
          this.feedChart(res.data);
        }
      });
    },
    feedChart(performances) {
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
      for (let i = 0; i < performances.length; i++) {
        var month = new Date(performances[i].created_at).getMonth() + 1;
        switch (month) {
          case 1:
            jan = performances[i].carrier_earning;
            this.chartData.push(["Jan", jan, 200]);
            break;
          case 2:
            feb = performances[i].carrier_earning;
            this.chartData.push(["Feb", feb, 300]);
            break;
          case 3:
            mar = performances[i].carrier_earning;
            this.chartData.push(["Mar", mar, 300]);
            break;
          case 4:
            apr = performances[i].carrier_earning;
            this.chartData.push(["Apr", apr, 200]);
            break;
          case 5:
            may = performances[i].carrier_earning;
            this.chartData.push(["May", may, 400]);
            console.log("you are at May");
            break;
          case 6:
            jun = performances[i].carrier_earning;
            this.chartData.push(["Jun", jun, 1000]);
            break;
          case 7:
            jul = performances[i].carrier_earning;
            this.chartData.push(["Jul", jul, 700]);
            break;
          case 8:
            aug = performances[i].carrier_earning;
            this.chartData.push(["Aug", aug, 200]);
            break;
          case 9:
            sep = performances[i].carrier_earning;
            this.chartData.push(["Sep", sep, 400]);
            break;
          case 10:
            oct = performances[i].carrier_earning;
            this.chartData.push(["Oct", oct, 200]);
            break;
          case 11:
            nov = performances[i].carrier_earning;
            this.chartData.push(["Nov", nov, 500]);
          case 12:
            dec = performances[i].carrier_earning;
            this.chartData.push(["Jan", dec, 200]);
            break;
        }
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

<style scoped lang="scss"></style>
