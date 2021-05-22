<template>
  <div>
    <md-card class="no-shadow-bordered">
      <md-card-header>
        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <div>
          <div class="md-title">Job Details</div>
          <div v-if="dataLoaded" class="job-id">
            <span>{{ job.order_detail.uniqid }}</span> |
            <span>{{ formatter(job.created_at) }}</span>
          </div>
        </div>
      </md-card-header>
      <md-card-content v-if="dataLoaded">
        <div class="status">
          <span>Status:</span>
          <md-menu md-size="auto" :mdCloseOnSelect="true" v-if="dataLoaded">
            <md-button
              md-menu-trigger
              v-bind:class="{ delivered: job.jobstatus.id == 5 }"
              >{{ job.jobstatus.title }}</md-button
            >

            <md-menu-content>
              <md-menu-item
                v-for="state in status"
                :key="state.id"
                @click="updateJob(state.id)"
                >{{ state.title }}</md-menu-item
              >
            </md-menu-content>
          </md-menu>
          <div v-show="dataLoading" class="loading">
            <Spinner />
          </div>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading">Origin Details</h3>
              <div class="body-1">
                Address:
                {{ job.order_detail.addresses[0].formatted_address }}
              </div>
              <div class="body-1" v-if="job.order_detail.floor_from">
                Floor:
                {{ job.order_detail.floor_from }}
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading">Destination Details</h3>
              <div class="body-1">
                Address:
                {{ job.order_detail.addresses[1].formatted_address }}
              </div>
              <div class="body-1" v-if="job.order_detail.floor_to">
                Floor:
                {{ job.order_detail.floor_to }}
              </div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading">Selected Supplies</h3>
              <div v-if="job.order_detail.supplies.length > 0">
                <div
                  class="body-1"
                  v-for="(supply, index) in job.order_detail.supplies"
                  :key="index"
                >
                  {{ supply.name }}:
                  {{ supply.pivot.number }}
                </div>
              </div>
              <div v-else>Not selected</div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading">Contact Details</h3>
              <div class="body-1">Contact name: {{ job.order_detail.contact.name }}</div>
              <div class="body-1">Phone: {{ job.order_detail.contact.phone }}</div>
              <div class="body-1">Email: {{ job.order_detail.contact.email }}</div>
            </md-card-content>
          </md-card>
        </div>

        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading">Other Information</h3>
              <div class="body-1">Pickup date: {{ job.order_detail.pickup_date }}</div>
              <div class="body-1">
                Appointment: {{ job.order_detail.appointment_time }}
              </div>

              <div class="body-1" v-if="job.order_detail.movingsize">
                Moving size: {{ job.order_detail.movingsize.title }}
              </div>

              <div class="body-1" v-if="job.order_detail.movernumber">
                Requested number of movers: {{ job.order_detail.movernumber.number }}
              </div>
              <div class="body-1" v-if="job.order_detail.vehicle">
                Requested vehicle: {{ job.order_detail.vehicle.name }}
              </div>
              <div class="body-1">Instructions: {{ job.order_detail.instructions }}</div>
            </md-card-content>
          </md-card>
          <md-card class="des" v-if="job.order_detail.items.length > 0">
            <md-card-content>
              <h3 class="md-subheading">Selected Items</h3>
              <div v-for="item in job.order_detail.items" :key="item.id">
                <div class="body-1">{{ item.name }} : {{ item.pivot.number }}</div>
              </div>
            </md-card-content>
          </md-card>
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button class="md-icon-button mark-as-read" @click="markAsRead()">
          <md-icon>done</md-icon>
          <md-tooltip>Mark as read</md-tooltip>
        </md-button>
      </md-card-actions>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
import Spinner from "../../../shared/Spinner";
import functions from "../../../frontend/services/functions";
export default {
  name: "JobDetails",
  props: ["jobId"],
  data: () => ({
    job: null,
    active: false,
    hasHistory: false,
    notification: null,
    notificationId: null,
    dataLoaded: false,
    status: [],
    selectedStatus: null,
    dataLoading: false,
    emails: {
      src: null,
      des: null,
    },
  }),
  methods: {
    jobDetails() {
      axios
        .get("carrier/jobs/" + this.$route.params.id)
        .then((res) => {
          console.log("job details ", res.data);
          if (res.data) {
            this.dataLoaded = true;
            this.job = res.data;
            this.getDistance(
              res.data.order_detail.addresses[0].formatted_address,
              res.data.order_detail.addresses[1].formatted_address
            );
            return;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    markAsRead() {
      axios
        .get("auth/read-notification/" + this.notificationId)
        .then((res) => {
          console.log(res.data);
          this.$router.replace("../jobs");
        })
        .catch((err) => {
          console.log(err);
        });
    },

    updateJob(statusId) {
      this.dataLoading = true;
      axios
        .put("admin/jobs/" + this.$route.params.id, {
          status: statusId,
          email: this.job.order_detail.contact.email,
          order: this.job.order_detail.id,
          moving_size:
            this.job.order_detail.type == "office"
              ? this.job.order_detail.officesize
              : this.job.order_detail.movingsize,
          cost: this.job.order_detail.cost,
          vehicle: this.job.order_detail.vehicle,
          supplies: this.job.order_detail.supplies,
          floor_from: this.job.order_detail.floor_from,
          floor_to: this.job.order_detail.floor_to,
          distance: this.distance,
          duration: this.duration,
          carrier_id: this.job.carrier_id,
        })
        .then((res) => {
          this.job = res.data;
          this.dataLoading = false;
          console.log("updated job: ", res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getJobStatus() {
      axios
        .get("carrier/job-status")
        .then((res) => {
          console.log("job statues: ", res.data);
          this.status = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getDistance(from, to) {
      var service = new google.maps.DistanceMatrixService();
      service.getDistanceMatrix(
        {
          origins: [from],
          destinations: [to],
          travelMode: google.maps.TravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.metric,
          avoidHighways: false,
          avoidTolls: false,
        },
        this.callback
      );
    },
    callback(response, status) {
      if (status != "OK") {
        console.log("Faild to get distance");
      } else {
        this.distance = (response.rows[0].elements[0].distance.value / 1000).toFixed(1); //in km
        this.duration = (response.rows[0].elements[0].duration.value / 60 / 60).toFixed(
          1
        );
      }
    },
    formatter(date) {
      return functions.myDateFormat(date);
    },
    checkStatus(status) {
      return status == 5 ? true : false;
    },
  },
  created() {
    this.jobDetails();
    this.getJobStatus();
    this.notificationId = this.$store.state.shared.notificationId;
  },
  watch: {
    $route() {
      this.notificationId = this.$store.state.shared.notificationId;
      this.jobDetails();
    },
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
    color: #ffa500;
  }
}
</style>
