<template>
  <div class="container">
    <div class="text-center mt-5">
      <PieChart />
    </div>
    <b-card-group>
      <div class="p-2 w-50">
        <b-card header="MONTHLY RECEIVED JOBS" class="shadow border-0">
          <ColumnChart />
        </b-card>
      </div>
      <div class="p-2 w-50">
        <b-card header="MONTHLY REVENUE " class="shadow border-0">
          <LineChart />
        </b-card>
      </div>
    </b-card-group>
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
.container {
  min-height: calc(100vh - 50px);
}

@media only screen and (max-width: 600px) {
}
</style>
