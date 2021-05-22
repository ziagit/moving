<template>
  <div>
    <div class="company">
      <img :src="'/images/uploads/transparent.svg'" width="100" alt="" />
      <div class="break"></div>
      <div class="md-display-1">
        {{ jobs.length > 0 ? jobs[0].carrier.company : "No data availabe" }}
      </div>
    </div>
    <div class="break"></div>
    <div class="break"></div>
    <md-card>
      <md-card-header>({{ currentYear }}) Graph</md-card-header>
      <md-card-content>
        <GChart type="LineChart" :data="performanceData" :options="performanceOptions" />
      </md-card-content>
      <div class="break"></div>
      <div class="break"></div>
      <div class="list">
        <div class="md-title">Overall Activities</div>
        <div class="md-body-1">
          Received Jobs: <b>{{ total }}</b>
        </div>
        <div class="md-body-1">
          Completed Jobs: <b>{{ completed }}</b>
        </div>
        <div class="md-body-1">
          Canceled/declined Jobs: <b>{{ canceled }}</b>
        </div>
        <div class="md-body-1">
          Pending Jobs: <b>{{ pending }}</b>
        </div>

        <div style="display: flex" v-if="jobs.length > 0">
          <span>My value in the market: </span>
          <StarRating
            v-if="jobs"
            v-model="jobs[0].carrier.votes"
            :star-size="18"
            :read-only="true"
          />
        </div>
        <div class="break"></div>
        <div class="break"></div>
        <md-button class="custom-button" to="/carrier/history">My job board</md-button>
      </div>
    </md-card>
  </div>
</template>

<script>
import StarRating from "vue-star-rating";
import { GChart } from "vue-google-charts";
import axios from "axios";
export default {
  data: () => ({
    rating: 3,
    jobs: [],
    total: 0,
    completed: 0,
    canceled: 0,
    pending: 0,
    currentYear: null,
    performanceData: [
      ["Month", "Jobs"],
      ["Jan", 1000],
      ["Feb", 1170],
      ["Mar", 1170],
      ["Apr", 1210],
      ["May", 1310],
    ],
    performanceOptions: {
      chart: {
        title: "Company Profit",
        subtitle: "Sales, Expenses, and Profit: 2014-2020",
      },
    },
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
          console.log("ressssssssssss", res.data);
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
  components: {
    GChart,
    StarRating,
  },
};
</script>

<style scoped lang="scss">
.company {
  img {
    padding: 10px;
    border-radius: 50px;
    box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
  }
}
.md-card {
  box-shadow: none;
}
.list {
  text-align: left;
  padding-left: 69px;
}
</style>
