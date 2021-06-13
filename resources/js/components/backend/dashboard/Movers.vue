<template>
  <div class="container">
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
    chartData: [["Month", "Movers"]],
    chartOptions: {
      chart: {
        title: "Movers",
        subtitle: "Mover companies registered with us: 2014-2020 ",
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
      axios.get("admin/dashboard/movers").then((res) => {
        if (res.data.length > 0) {
          this.feedChart(res.data);
        }
      });
    },
    feedChart(movers) {
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
      for (let i = 0; i < movers.length; i++) {
        var month = new Date(movers[i].created_at).getMonth() + 1;
        switch (month) {
          case 1:
            jan += 1;
            this.chartData.push(["Jan", jan]);
            break;
          case 2:
            feb += 1;
            this.chartData.push(["Feb", feb]);
            console.log("you are at feb");
            break;
          case 3:
            mar += 1;
            this.chartData.push(["Mar", mar]);
            break;
          case 4:
            apr += 1;
            this.chartData.push(["Apr", apr]);
            break;
          case 5:
            may += 1;
            this.chartData.push(["May", may]);
            console.log("you are at May");
            break;
          case 6:
            jun += 1;
            this.chartData.push(["Jun", jun]);
            break;
          case 7:
            jul += 1;
            this.chartData.push(["Jul", jul]);
            break;
          case 8:
            aug += 1;
            this.chartData.push(["Aug", aug]);
            break;
          case 9:
            sep += 1;
            this.chartData.push(["Sep", sep]);
            break;
          case 10:
            oct += 1;
            this.chartData.push(["Oct", oct]);
            break;
          case 11:
            nov += 1;
            this.chartData.push(["Nov", nov]);
          case 12:
            dec += 1;
            this.chartData.push(["Jan", dec]);
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

<style scoped lang="scss">
.container {
  width: 100%;
}
</style>
