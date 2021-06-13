<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="confirmTogal"
      md-title="Confirmation"
      :md-content="confirmText"
      md-confirm-text="Agree"
      md-cancel-text="Disagree"
      @md-cancel="onCancel"
      @md-confirm="onConfirm"
    />
    <md-card v-if="job" class="outer-card">
      <md-card-header class="head">
        <div class="status">
          <span>Status: {{ job.order_detail.status }}</span>
          <div>
            <Spinner v-if="isSubmitting" />
            <div v-else class="actions">
              <md-button
                class="custom-button"
                :disabled="job.order_detail.status != 'New'"
                v-bind:class="{ inactive: job.order_detail.status != 'New' }"
                @click="edit('Accepted')"
                >Accept</md-button
              >
              <md-button
                class="custom-button"
                @click="edit('Declined')"
                :disabled="
                  job.order_detail.status == 'Accepted' ||
                  job.order_detail.status == 'Declined' ||
                  job.order_detail.status == 'Completed'
                "
                v-bind:class="{
                  inactive:
                    job.order_detail.status == 'Accepted' ||
                    job.order_detail.status == 'Declined' ||
                    job.order_detail.status == 'Completed',
                }"
                >Decline</md-button
              >
              <md-button
                class="custom-button"
                @click="edit('Completed')"
                :disabled="
                  job.order_detail.status == 'New' ||
                  job.order_detail.status == 'Declined' ||
                  job.order_detail.status == 'Completed'
                "
                v-bind:class="{
                  inactive:
                    job.order_detail.status == 'New' ||
                    job.order_detail.status == 'Declined' ||
                    job.order_detail.status == 'Completed',
                }"
                >Complete</md-button
              >
            </div>
          </div>
        </div>
      </md-card-header>
      <md-card-content v-if="job">
        <div class="cols">
          <div class="col">
            <md-card class="col1">
              <md-card-header><span class="md-title">Job</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span>Job: </span>
                  <span>{{ job.order_detail.uniqid }}</span>
                </div>
                <div class="row">
                  <span>Placed on: </span>
                  <span>{{ formateDate(job.order_detail.created_at) }}</span>
                </div>
                <div class="row">
                  <span>Pickup: </span>
                  <span>{{ job.order_detail.addresses[0].formatted_address }}</span>
                </div>
                <div class="row">
                  <span>Floor: </span>
                  <span>{{
                    job.order_detail.floor_from
                      ? job.order_detail.floor_from
                      : "No stairs"
                  }}</span>
                </div>
                <div class="row">
                  <span>Destination: </span>
                  <span>{{ job.order_detail.addresses[1].formatted_address }}</span>
                </div>
                <div class="row">
                  <span>Floor: </span>
                  <span>{{
                    job.order_detail.floor_to ? job.order_detail.floor_to : "No stairs"
                  }}</span>
                </div>
                <div class="row" v-if="job.order_detail.movingtype.code == 'apartment'">
                  <span>Moving size: </span>
                  <span>{{ job.order_detail.movingsize.title }}</span>
                </div>
                <div class="row" v-if="job.order_detail.movingtype.code == 'office'">
                  <span>Office size: </span>
                  <span>{{ job.order_detail.officesize.title }}</span>
                </div>
                <div class="row" v-if="job.order_detail.movernumber">
                  <span>Number of movers: </span>
                  <span> {{ job.order_detail.movernumber.number }}</span>
                </div>
                <div class="row" v-if="job.order_detail.vehicle">
                  <span>Vehicle: </span>
                  <span> {{ job.order_detail.vehicle.name }}</span>
                </div>
                <div class="row">
                  <span>Schedualed date: </span>
                  <span> {{ job.order_detail.pickup_date }}</span>
                </div>
                <div class="row">
                  <span>Time window: </span>
                  <span> {{ job.order_detail.appointment_time }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span>Type: </span>
                  <span> {{ job.order_detail.movingtype.title }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span>Instructions: </span>
                  <span>
                    {{
                      job.order_detail.instructions
                        ? job.order_detail.instructions
                        : "Not given"
                    }}</span
                  >
                </div>
              </md-card-content>
            </md-card>
          </div>
          <div class="col">
            <md-card>
              <md-card-header><span class="md-title">Supplies</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span v-if="job.order_detail.supplies.length > 0">
                    <div
                      v-for="(supply, index) in job.order_detail.supplies"
                      :key="index"
                      class="list"
                    >
                      <span>{{ supply.name }}:</span>
                      <span> {{ supply.pivot.number }}</span>
                    </div>
                  </span>
                  <span v-else>Not selected</span>
                </div>
              </md-card-content>
            </md-card>
            <md-card v-if="job.order_detail.items.length > 0">
              <md-card-header><span class="md-title">Items</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span>
                    <div
                      v-for="(item, index) in job.order_detail.items"
                      :key="index"
                      class="list"
                    >
                      <span>{{ item.name }}:</span>
                      <span> {{ item.pivot.number }}</span>
                    </div>
                  </span>
                </div>
              </md-card-content>
            </md-card>
            <md-card>
              <md-card-header><span class="md-title">Price</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span><strong>Total:</strong> </span>
                  <span
                    ><strong>${{ job.order_detail.cost }}</strong></span
                  >
                </div>
                <div class="row">
                  <span>Moving cost: </span>
                  <span>${{ job.order_detail.moving_cost }}</span>
                </div>
                <div class="row">
                  <span>Travel cost: </span>
                  <span>${{ job.order_detail.travel_cost }}</span>
                </div>
                <div class="row">
                  <span>Service fee: </span>
                  <span>${{ job.order_detail.service_fee }}</span>
                </div>
                <div class="row" v-if="job.order_detail.disposal_fee">
                  <span>Disposal fee: </span>
                  <span>${{ job.order_detail.disposal_fee }}</span>
                </div>
                <div class="row">
                  <span>Tax: </span>
                  <span>${{ job.order_detail.tax }}</span>
                </div>
                <div class="row" v-if="job.order_detail.tips">
                  <span>Tips: </span>
                  <span>${{ job.order_detail.tips }}</span>
                </div>
              </md-card-content>
            </md-card>
            <md-card>
              <md-card-header
                ><span class="md-title">Customer contact</span></md-card-header
              >
              <md-card-content>
                <div class="row">
                  <span>Name: </span>
                  <span>{{ job.order_detail.shipper_contacts.user.name }}</span>
                </div>
                <div class="row">
                  <span>Email: </span>
                  <span>{{ job.order_detail.shipper_contacts.user.email }}</span>
                </div>
                <div class="row">
                  <span>Phone: </span>
                  <span>{{ job.order_detail.shipper_contacts.user.phone }}</span>
                </div>
              </md-card-content>
            </md-card>
          </div>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Spinner from "../../../shared/Spinner";
import services from "../../services/orderSchedualer";
import dateFormatter from "../../services/dateFormatter";
export default {
  name: "JobDetails",
  data: () => ({
    job: null,
    notification: null,
    notificationId: null,
    isSubmitting: false,
    confirmTogal: false,
    confirmText: null,
    status: null,
  }),
  created() {
    this.jobDetails();
    this.notificationId = this.$store.state.shared.notificationId;
  },
  methods: {
    checkMovingTime(date, time) {
      return services.movingExpiration(date, time);
    },
    checkItemTime(date, time) {
      return services.itemExpiration(date, time);
    },
    formateDate(date) {
      return dateFormatter.format(date);
    },

    jobDetails() {
      axios
        .get("carrier/jobs/" + this.$route.params.id)
        .then((res) => {
          console.log("job details ", res.data);
          if (res.data) {
            this.job = res.data;
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
    edit(status) {
      this.confirmText = "Do you mark this order as " + status + " ?";
      this.status = status;
      this.confirmTogal = true;
    },
    onCancel() {},
    onConfirm() {
      this.isSubmitting = true;
      this.job["status"] = this.status;
      this.job["notification_id"] = this.notificationId;
      axios
        .put("carrier/jobs/" + this.$route.params.id, this.job)
        .then((res) => {
          this.isSubmitting = false;
          this.jobDetails();
          console.log("updated job: ", res.data);
        })
        .catch((err) => {
          console.log(err);
          this.isSubmitting = false;
        });
    },
  },

  watch: {
    $route() {
      this.notificationId = this.$store.state.shared.notificationId;
      //this.jobDetails();
    },
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
