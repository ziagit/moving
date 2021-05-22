<template>
  <div>
    <md-card class="no-shadow-bordered" v-if="earning != null">
      <md-card-header>
        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <div>
          <div class="md-title md-primary">Details</div>
          <div class="job-id">
            <span>{{ earning.order_detail.uniqid }}</span> |
            <span>{{ formatter(earning.created_at) }}</span>
          </div>
        </div>
      </md-card-header>

      <md-card-content>
        <div class="status">
          <span>Status: {{ earning.status == "unpaid" ? "Unpaid" : "Paid" }}</span>
        </div>
        <md-card class="des">
          <md-card-content>
            <h3 class="md-subheading md-primary">Price breakdonw</h3>
            <div class="body-1">Distance charge: ${{ earning.distance_charge }}</div>
            <div class="body-1">Moving charge: ${{ earning.moving_charge }}</div>
            <div class="body-1">Vehicle charge: ${{ earning.vehicle_charge }}</div>
            <div class="break"></div>
            <div class="body-1">
              <b
                >Total:
                <span style="color: green"
                  >${{
                    earning.distance_charge +
                    earning.moving_charge +
                    earning.vehicle_charge
                  }}</span
                ></b
              >
            </div>
          </md-card-content>
        </md-card>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Origin details</h3>
              <div class="body-1">
                Address:
                {{ earning.order_detail.addresses[0].formatted_address }}
              </div>
              <div class="body-1" v-if="earning.order_detail.floor_from">
                Floor:
                {{ earning.order_detail.floor_from }}
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Destination details</h3>
              <div class="body-1">
                Address:
                {{ earning.order_detail.addresses[1].formatted_address }}
              </div>
              <div class="body-1" v-if="earning.order_detail.floor_to">
                Floor:
                {{ earning.order_detail.floor_to }}
              </div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Selected supplies</h3>
              <div
                class="body-1"
                v-for="(supply, index) in earning.order_detail.supplies"
                :key="index"
              >
                {{ supply.name }}:
                {{ supply.pivot.number }}
              </div>
            </md-card-content>
          </md-card>

          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Other information</h3>
              <div class="body-1">
                Pickup date: {{ earning.order_detail.pickup_date }}
              </div>
              <div class="body-1">
                Appointment: {{ earning.order_detail.appointment_time }}
              </div>
              <div class="body-1">Moving type: {{ earning.order_detail.type }}</div>
              <div class="body-1" v-if="earning.order_detail.movernumber">
                Requested number of movers: {{ earning.order_detail.movernumber.number }}
              </div>
              <div class="body-1">
                Requested vehicle: {{ earning.order_detail.vehicle.name }}
              </div>
              <div class="body-1">
                Instructions: {{ earning.order_detail.instructions }}
              </div>
            </md-card-content>
          </md-card>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
import Spinner from "../../../shared/Spinner";
import functions from "../../services/functions";
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
        .get("carrier/earnings/" + this.$route.params.id)
        .then((res) => {
          this.earning = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    formatter(date) {
      return functions.myDateFormat(date);
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
.md-card {
  text-align: center;

  .status {
    display: flex;
    justify-content: flex-end;
    align-items: center;

    .delivered {
      color: green !important;
    }
  }

  .md-card {
    margin: 5px;
  }

  .src,
  .des,
  .items,
  .order_detail {
    box-shadow: none;
    border: 1px solid rgb(241, 241, 241);
    text-align: left;
  }

  .order_detail {
    margin-top: 11px;
  }

  .src-des {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .src {
      flex: 1;
    }

    .des {
      flex: 1;
    }
  }

  .close-btn {
    position: absolute;
    top: 0;
    right: 0;
  }

  .job-id {
    span {
      font-size: 11px;
      margin: 0;
      padding: 0;
    }
  }

  .md-subheading {
    font-size: 18px;
  }
}
</style>
