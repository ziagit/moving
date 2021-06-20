<template>
  <div class="jobs">
    <b-card class="border-0 shadow text-left" header="Jobs">
      <b-form-input placeholder="Search by Order" v-model="keywords"></b-form-input>
      <div class="table-responsive-sm">
        <table class="table table-light">
          <thead>
            <tr>
              <th scope="col">Order</th>
              <th scope="col">Date</th>
              <th scope="col">Time</th>
              <th scope="col">Type</th>
              <th scope="col">Price</th>
              <th scope="col">Status</th>
              <th scope="col">Details</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(job, index) in jobs.data" :key="index">
              <td>{{ job.order_detail.uniqid }}</td>
              <td>{{ job.order_detail.pickup_date }}</td>
              <td>{{ job.order_detail.appointment_time }}</td>
              <td>{{ job.order_detail.movingtype.title }}</td>
              <td>${{ job.order_detail.cost }}</td>
              <td>{{ job.order_detail.status }}</td>
              <td>
                <b-button variant="light" @click="details(job.id)"
                  ><b-icon variant="primary" icon="three-dots"></b-icon
                ></b-button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </b-card>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "shipper",
  data: () => ({
    keywords: null,
    jobs: [],
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

<style lang="scss" scoped></style>
