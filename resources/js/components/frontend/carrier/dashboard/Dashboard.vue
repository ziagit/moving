<template>
  <div class="dashboard">
    <div class="break"></div>
    <div class="row">
      <PieChart />
    </div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="row">
      <md-card>
        <md-card-content>MONTHLY RECEIVED JOBS </md-card-content>
        <md-card-actions>
          <ColumnChart />
        </md-card-actions>
      </md-card>
      <md-card>
        <md-card-content> MONTHLY REVENUE </md-card-content>
        <md-card-actions>
          <LineChart />
        </md-card-actions>
      </md-card>
    </div>
  </div>
</template>

<script>
import PieChart from "./PieChart";
import ColumnChart from "./ColumnChart";
import LineChart from "./LineChart";
export default {
  components: {
    PieChart,
    LineChart,
    ColumnChart,
  },
};
</script>

<style scoped lang="scss">
.dashboard {
  margin-bottom: 30px;
}
.row {
  display: flex;
  justify-content: space-evenly;
}
@media only screen and (max-width: 600px) {
  .row {
    flex-direction: column;
  }
}
</style>
