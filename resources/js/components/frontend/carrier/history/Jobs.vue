<template>
  <div class="jobs" v-if="jobs">
    <md-table md-sort="first_name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <span class="md-title">Jobs</span>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head>Order</md-table-head>
        <md-table-head>Date</md-table-head>
        <md-table-head>Time</md-table-head>
        <md-table-head>Type</md-table-head>
        <md-table-head>Price</md-table-head>
        <md-table-head>Status</md-table-head>
        <md-table-head>Details</md-table-head>
      </md-table-row>
      <md-table-row v-for="job in jobs.data" :key="job.id">
        <md-table-cell>{{ job.order_detail.uniqid }}</md-table-cell>
        <md-table-cell>{{ job.order_detail.pickup_date }}</md-table-cell>
        <md-table-cell>{{ job.order_detail.appointment_time }}</md-table-cell>
        <md-table-cell>{{ job.order_detail.movingtype.title }}</md-table-cell>
        <md-table-cell>${{ job.order_detail.cost }}</md-table-cell>
        <md-table-cell> {{ job.order_detail.status }}</md-table-cell>
        <md-table-cell>
          <md-button @click="details(job.id)"><md-icon>more_horiz</md-icon></md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="jobs" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "shipper",
  data: () => ({
    keywords: null,
    jobs: null,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("carrier/search-job", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.jobs = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("carrier/jobs?page=" + page)
        .then((res) => {
          console.log("shpers: ", res.data.data);
          this.jobs = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    details(id) {
      this.$router.push("details/" + id);
    },
  },
  created() {
    this.get();
  },
  components: {},
};
</script>

<style lang="scss" scoped>
.jobs {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
  .md-toolbar-section-start {
    text-align: left;
  }
}
</style>
