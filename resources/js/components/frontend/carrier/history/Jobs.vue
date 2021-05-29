<template>
  <div>
    <md-card>
      <md-card-header>
        <div class="md-title">Job History</div>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <table class="table" v-if="jobs">
          <thead>
            <tr>
              <th>Order</th>
              <th>From</th>
              <th>To</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>Details</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="job in jobs" :key="job.id">
              <td>{{ job.order_detail.uniqid }}</td>
              <td>{{ job.order_detail.addresses[0].city }}</td>
              <td>{{ job.order_detail.addresses[1].city }}</td>
              <td>{{ job.order_detail.pickup_date }}</td>
              <td>{{ job.order_detail.appointment_time }}</td>
              <td v-bind:class="{ canceled: job.order_detail.status == 'Canceled' }">
                {{ job.order_detail.status }}
              </td>

              <td>
                <md-button
                  :to="{ path: 'details/' + job.id }"
                  class="md-primay md-icon-button"
                >
                  <md-icon>more_horiz</md-icon>
                  <md-tooltip>View more</md-tooltip>
                </md-button>
              </td>
            </tr>
          </tbody>
        </table>
        <md-empty-state
          class="md-primary"
          md-icon="done"
          md-label="No Jobs"
          md-description="Customer orders will be assigning to you here."
          v-if="jobs == null"
        ></md-empty-state>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
import functions from "../../services/functions";
export default {
  name: "Jobs",
  data: () => ({
    jobs: null,
  }),
  methods: {
    getJobs() {
      axios
        .get("carrier/jobs")
        .then((res) => {
          this.jobs = res.data;
          console.log("job list ", this.jobs);
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
  },
  created() {
    this.getJobs();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .table {
    width: 100%;
    border-collapse: collapse;

    th,
    td {
      border: 1px solid #ddd;
      text-align: center;
    }

    .canceled {
      color: red !important;
    }
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
