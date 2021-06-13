<template>
  <div>
    <md-card v-if="earning" class="outer-card">
      <md-card-header class="head">
        <div class="status">
          <span>Status: {{ earning.status }}</span>
          <div></div>
        </div>
      </md-card-header>
      <md-card-content>
        <div class="cols">
          <div class="col">
            <md-card class="col1">
              <md-card-header><span class="md-title">Breakdown</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span><strong>Total amount to be collected:</strong> </span>
                  <span
                    ><strong> ${{ earning.carrier_earning }}</strong></span
                  >
                </div>
                <div class="break"></div>
                <div class="row">
                  <span>Travel cost: </span>
                  <span>${{ earning.order_detail.travel_cost }}</span>
                </div>
                <div class="row">
                  <span>Moving cost: </span>
                  <span>${{ earning.order_detail.moving_cost }}</span>
                </div>
                <div class="row">
                  <span>Received tips: </span>
                  <span
                    >${{
                      earning.order_detail.tips ? earning.order_detail.tips : 0
                    }}</span
                  >
                </div>
                <div class="row">
                  <span>Supplies cost: </span>
                  <span>
                    ${{
                      earning.order_detail.supplies_cost
                        ? earning.order_detail.supplies_cost
                        : 0
                    }}</span
                  >
                </div>
              </md-card-content>
            </md-card>
          </div>
          <div class="col">
            <md-card>
              <md-card-header><span class="md-body-2">Service fee</span></md-card-header>
              <md-card-content
                >${{
                  earning.order_detail.service_fee ? earning.order_detail.service_fee : 0
                }}
              </md-card-content>
            </md-card>
            <md-card>
              <md-card-header><span class="md-body-2">Disposal fee</span></md-card-header>
              <md-card-content>
                ${{ earning.disposal_fee ? earning.order_detail.disposal_fee : 0 }}
              </md-card-content>
            </md-card>

            <md-card>
              <md-card-header><span class="md-body-2">Payable tax</span></md-card-header>
              <md-card-content>
                ${{ earning.unpaid_gst ? earning.unpaid_gst : 0 }}
              </md-card-content>
            </md-card>
          </div>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
import Spinner from "../../../shared/Spinner";
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

  components: {
    Spinner,
  },
};
</script>

<style lang="scss" scoped>
.outer-card {
  box-shadow: none;
  .head {
    margin: 0 !important;
    padding: 10px 25px;
  }
}
.cols {
  display: flex;
  justify-content: space-between;
  .col {
    flex: 1;
    .md-card {
      text-align: left;
      .row {
        display: flex;
        > :first-child {
          min-width: 132px;
        }
        .list {
          display: flex;
          justify-content: space-between;
        }
      }
    }
  }
  .col1 {
    height: 98%;
  }
}
.md-card {
  text-align: center;
  margin: 0 20px;
  .status {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .md-card {
    margin: 5px;
  }
  .inactive {
    background: #ddd;
    box-shadow: none;
  }
}
</style>
