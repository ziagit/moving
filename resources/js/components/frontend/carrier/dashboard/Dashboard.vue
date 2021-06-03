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
import StarRating from "vue-star-rating";
import PieChart from "./PieChart";
import ColumnChart from "./ColumnChart";
import LineChart from "./LineChart";
import axios from "axios";
export default {
  components: {
    PieChart,
    LineChart,
    ColumnChart,
    StarRating,
  },
  data: () => ({
    rating: 3,
    jobs: [],
    total: 0,
    completed: 0,
    canceled: 0,
    pending: 0,
    currentYear: null,
  }),
  created() {
    this.get();
    let d = new Date();
    this.currentYear = d.getFullYear();
  },
  methods: {
    get() {
      axios
        .get("carrier/dashboard")
        .then((res) => {
          this.jobs = res.data;
          this.total = res.data.length;
          for (let i = 0; i < res.data.length; i++) {
            if (res.data[i].order_detail.status == "Completed") {
              this.completed = this.completed + i == 0 ? 1 : i;
            } else if (
              res.data[i].order_detail.status == "Canceled" ||
              res.data[i].order_detail.status == "Declined"
            ) {
              this.canceled = this.canceled + i == 0 ? 1 : i;
            } else {
              this.pending = this.pending + i == 0 ? 1 : i;
            }
          }
        })
        .catch((err) => console.log(err));
    },
  },
  mounted: function () {},
};
</script>

<style scoped lang="scss">
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
