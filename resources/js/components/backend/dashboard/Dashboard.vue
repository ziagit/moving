<template>
  <div class="container">
    <b-card class="mt-5 text-center border-0" title="DAYLY PROJECTIONS">
      <DailyProjections />
    </b-card>
    <b-card-group>
      <div class="p-2 w-50">
        <b-card class="shadow border-0" header="MONTHLY SALES">
          <Sales />
        </b-card>
      </div>
      <div class="p-2 w-50">
        <b-card class="shadow border-0" header="PERFOMANCE">
          <Performance />
        </b-card>
      </div>
    </b-card-group>
    <br />
    <b-card-group class="mb-5">
      <div class="p-2 w-50">
        <b-card class="shadow border-0" header="CUSTOMERS">
          <Customers />
        </b-card>
      </div>
      <div class="p-2 w-50">
        <b-card header="MOVERS" class="shadow border-0">
          <Movers />
        </b-card>
      </div>
    </b-card-group>
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

<style scoped lang="scss"></style>
