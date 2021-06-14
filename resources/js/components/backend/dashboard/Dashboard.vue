<template>
  <div>
    <div class="row">
      <md-card class="card-1">
        <md-card-header><span class="md-title">DAYLY PROJECTIONS</span></md-card-header>
        <md-card-content>
          <DailyProjections />
        </md-card-content>
      </md-card>
    </div>
    <br />
    <div class="row">
      <md-card>
        <md-card-header>MONTHLY SALES</md-card-header>
        <md-card-content>
          <Sales />
        </md-card-content>
      </md-card>
      <md-card>
        <md-card-header>PERFOMANCE</md-card-header>
        <md-card-content>
          <Performance />
        </md-card-content>
      </md-card>
    </div>
    <br />
    <div class="row">
      <md-card>
        <md-card-header>CUSTOMERS</md-card-header>
        <md-card-content>
          <Customers />
        </md-card-content>
      </md-card>
      <md-card>
        <md-card-header>MOVERS</md-card-header>
        <md-card-content>
          <Movers />
        </md-card-content>
      </md-card>
    </div>
  </div>
</template>

<script>
import DailyProjections from "./DailyProjections";
import Customers from "./Customers";
import Movers from "./Movers";
import Performance from "./Performance";
import Sales from "./Sales";
export default {
  components: {
    DailyProjections,
    Customers,
    Movers,
    Sales,
    Performance,
  },
};
</script>

<style scoped lang="scss">
.row {
  display: flex;
  justify-content: space-between;
  .card-1 {
    box-shadow: none;
  }
  .md-card {
    width: 100%;
    text-align: center;
  }
}
</style>
