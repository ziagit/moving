<template>
  <div>
    <div v-if="earning" class="outer-card">
      <div class="status pl-3 pr-3 text-left">
        <span
          >Status: <b-badge pill variant="dark">{{ earning.status }}</b-badge></span
        >
      </div>
      <div class="cols">
        <div class="col">
          <b-card class="border-0 shadow text-left" header="Revenue">
            <div class="row">
              <span class="col-4">Travel cost: </span>
              <span class="col-8">${{ earning.order.travel_cost }}</span>
            </div>
            <div class="row">
              <span class="col-4">Moving cost: </span>
              <span class="col-5">${{ earning.order.moving_cost }}</span>
            </div>
            <div class="row">
              <span class="col-4">Received tips: </span>
              <span class="col-8"
                >${{ earning.order.tips ? earning.order.tips : 0 }}</span
              >
            </div>
            <div class="row">
              <span class="col-4">Supplies cost: </span>
              <span class="col-8">
                ${{ earning.order.supplies_cost ? earning.order.supplies_cost : 0 }}</span
              >
            </div>
            <div class="row">
              <span class="col-4">Disposal fee: </span>
              <span class="col-8">
                ${{ earning.disposal_fee ? earning.order.disposal_fee : 0 }}</span
              >
            </div>
            <div class="row">
              <span class="col-4">Servoce fee: </span>
              <span class="col-8">
                -${{ earning.order.service_fee ? earning.order.service_fee : 0 }}</span
              >
            </div>
            <div class="row">
              <span class="col-4">Payable tax: </span>
              <span class="col-8">
                ${{ earning.unpaid_gst ? earning.unpaid_gst : 0 }}</span
              >
            </div>
          </b-card>
        </div>
        <div class="col">
          <b-card class="border-0 shadow text-left" header="Earning">
            <div class="row">
              <span class="col-8">Total amount to be collected: </span>
              <span class="col-8"> ${{ earning.carrier_earning }}</span>
            </div>
          </b-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import formatter from "../../services/dateFormatter";
export default {
  name: "JobDetails",
  data: () => ({
    earning: null,
    distance: null,
    duration: null,
  }),
  methods: {
    details() {
      axios
        .get("carrier/earning/" + this.$route.params.id)
        .then((res) => {
          console.log("response", res.data);
          this.earning = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    formatter(date) {
      return formatter.format(date);
    },
  },
  created() {
    this.details();
  },

  components: {},
};
</script>

<style lang="scss" scoped>
.cols {
  display: flex;
  justify-content: space-evenly;
}
</style>
