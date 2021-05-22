<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="confirmDialog"
      md-title="Confirmation"
      md-content="Please confirm your actions"
      md-confirm-text="Ok"
      md-cancel-text="Cancel"
      @md-cancel="onCancel"
      @md-confirm="onConfirm"
    />
    <md-card v-if="job" class="no-shadow-bordered">
      <md-card-header>
        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <div>
          <div class="md-title md-primary">Job Details</div>
          <div class="job-id">
            <span>{{ job.order_detail.uniqid }}</span> |
            <span>{{ job.order_detail.pickup_date }}</span>
          </div>
        </div>
      </md-card-header>
      <md-card-content v-if="job">
        <div class="status">
          <div>
            <Spinner v-if="updating" />
            <div v-else class="actions">
              <md-button
                class="md-primary md-raised"
                @click="(status = 'Accepted'), (confirmDialog = true)"
                >Accept</md-button
              >
              <md-button
                class="md-primary md-raised"
                @click="(status = 'Declined'), (confirmDialog = true)"
                >Decline</md-button
              >
              <md-button
                class="md-primary md-raised"
                @click="(status = 'Completed'), (confirmDialog = true)"
                >Complete</md-button
              >
            </div>
          </div>
          <span>Status: {{ job.order_detail.status }}</span>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Pickup</h3>
              <div class="body-1">
                Address:
                {{ job.order_detail.addresses[0].formatted_address }}
              </div>
              <div class="body-1">
                Floor:
                {{
                  job.order_detail.floor_from ? job.order_detail.floor_from : "No stairs"
                }}
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Destination</h3>
              <div class="body-1">
                Address:
                {{ job.order_detail.addresses[1].formatted_address }}
              </div>

              <div class="body-1">
                Floor:
                {{ job.order_detail.floor_to ? job.order_detail.floor_to : "No stairs" }}
              </div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Selected Supplies</h3>
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
              <div v-else class="body-1">Not selected</div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Contact Details</h3>
              <div class="body-1">Contact name: {{ job.order_detail.contact.name }}</div>
              <div class="body-1">Phone: {{ job.order_detail.contact.phone }}</div>
              <div class="body-1">Email: {{ job.order_detail.contact.email }}</div>
            </md-card-content>
          </md-card>
        </div>

        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Other Information</h3>
              <div class="body-1">Pickup date: {{ job.order_detail.pickup_date }}</div>
              <div class="body-1">
                Appointment: {{ job.order_detail.appointment_time }}
              </div>
              <div class="body-1">Type: {{ job.order_detail.movingtype.title }}</div>
              <div class="body-1" v-if="job.order_detail.movingtype.code == 'apartment'">
                Moving size:
                {{ job.order_detail.movingsize.title }}
              </div>
              <div class="body-1" v-if="job.order_detail.movingtype.code == 'office'">
                Office size:
                {{ job.order_detail.officesize.title }}
              </div>

              <div class="body-1" v-if="job.order_detail.movernumber">
                Requested number of movers:
                {{ job.order_detail.movernumber.number }}
              </div>

              <div class="body-1" v-if="job.order_detail.vehicle">
                Requested vehicle: {{ job.order_detail.vehicle.name }}
              </div>

              <div class="body-1">
                Instructions:
                {{
                  job.order_detail.instructions
                    ? job.order_detail.instructions
                    : "Not given"
                }}
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des" v-if="job.order_detail.items.length > 0">
            <md-card-content>
              <h3 class="md-subheading md-primary">Selected Items</h3>
              <div v-for="item in job.order_detail.items" :key="item.id">
                <div class="body-1">{{ item.name }}: {{ item.pivot.number }}</div>
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
export default {
  name: "JobDetails",
  data: () => ({
    job: null,
    notification: null,
    notificationId: null,
    updating: false,
    confirmDialog: false,
    status: null,
  }),
  created() {
    this.jobDetails();
    this.notificationId = this.$store.state.shared.notificationId;
  },
  methods: {
    jobDetails() {
      axios
        .get("carrier/jobs/" + this.$route.params.id)
        .then((res) => {
          console.log("job details ", res.data);
          if (res.data) {
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
          console.log("marked as read:", res.data);
          //this.$router.replace("../jobs");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onCancel() {},
    onConfirm() {
      this.updating = true;
      axios
        .put("carrier/jobs/" + this.$route.params.id, {
          status: this.status,
          email: this.job.order_detail.contact.email,
          notification_id: this.notificationId,
          carrier_id: this.job.carrier_id,
          order_id: this.job.order_detail.id,
          moving_type: this.job.order_detail.movingtype,
          moving_size: this.job.order_detail.movingsize
            ? this.job.order_detail.movingsize
            : this.job.order_detail.officesize,
          cost: this.job.order_detail.cost,
          vehicle: this.job.order_detail.vehicle,
          supplies: this.job.order_detail.supplies,
          floor_from: this.job.order_detail.floor_from,
          floor_to: this.job.order_detail.floor_to,
          items: this.job.order_detail.items,
          distance: this.distance,
          duration: this.duration,
          number_of_movers: this.job.order_detail.movernumber,
        })
        .then((res) => {
          this.updating = false;

          this.jobDetails();
          console.log("updated job: ", res.data);
        })
        .catch((err) => {
          console.log(err);
          this.updating = false;
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
        this.duration = (response.rows[0].elements[0].duration.value / 60).toFixed(1);
      }
    },
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
    justify-content: space-between;
    align-items: center;
    .actions {
      .md-button {
        margin-left: 8px;
      }
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
