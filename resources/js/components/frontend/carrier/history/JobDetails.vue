<template>
  <div>
    <div v-if="job" class="outer-card">
      <div class="status pl-3 pr-3 d-flex justify-content-between">
        <span
          >Status:
          <b-badge pill variant="dark">{{ job.order_detail.status }}</b-badge>
        </span>
        <div>
          <b-spinner variant="primary" v-if="isSubmitting" />
          <b-button-group v-else>
            <b-button
              variant="primary"
              :disabled="job.order_detail.status != 'New'"
              @click="edit('Accepted')"
              >Accept</b-button
            >
            <b-button
              variant="warning"
              @click="edit('Declined')"
              :disabled="
                job.order_detail.status == 'Accepted' ||
                job.order_detail.status == 'Declined' ||
                job.order_detail.status == 'Completed' ||
                job.order_detail.status == 'Canceled'
              "
              >Decline</b-button
            >
            <b-button
              variant="success"
              @click="edit('Completed')"
              :disabled="
                job.order_detail.status == 'New' ||
                job.order_detail.status == 'Declined' ||
                job.order_detail.status == 'Completed' ||
                job.order_detail.status == 'Canceled'
              "
              >Complete</b-button
            >
          </b-button-group>
        </div>
      </div>
      <div v-if="job">
        <div class="cols">
          <div class="col">
            <b-card class="col1 border-0 shadow text-left" header="Job Details mb-3">
              <div class="row text-left">
                <span class="col-4">Job: </span>
                <span class="col-8">{{ job.order_detail.uniqid }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Placed on: </span>
                <span class="col-8">{{ formateDate(job.order_detail.created_at) }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Pickup: </span>
                <span class="col-8">{{
                  job.order_detail.addresses[0].formatted_address
                }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Floor: </span>
                <span class="col-8">{{
                  job.order_detail.floor_from ? job.order_detail.floor_from : "No stairs"
                }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Destination: </span>
                <span class="col-8">{{
                  job.order_detail.addresses[1].formatted_address
                }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Floor: </span>
                <span class="col-8">{{
                  job.order_detail.floor_to ? job.order_detail.floor_to : "No stairs"
                }}</span>
              </div>
              <div
                class="row text-left"
                v-if="job.order_detail.movingtype.code == 'apartment'"
              >
                <span class="col-4">Moving size: </span>
                <span class="col-8">{{ job.order_detail.movingsize.title }}</span>
              </div>
              <div
                class="row text-left"
                v-if="job.order_detail.movingtype.code == 'office'"
              >
                <span class="col-4">Office size: </span>
                <span class="col-8">{{ job.order_detail.officesize.title }}</span>
              </div>
              <div class="row text-left" v-if="job.order_detail.movernumber">
                <span class="col-4">Number of movers: </span>
                <span class="col-8"> {{ job.order_detail.movernumber.number }}</span>
              </div>
              <div class="row text-left" v-if="job.order_detail.vehicle">
                <span class="col-4">Vehicle: </span>
                <span class="col-8"> {{ job.order_detail.vehicle.name }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Schedualed date: </span>
                <span class="col-8"> {{ job.order_detail.pickup_date }}</span>
              </div>
              <div class="row text-left">
                <span class="col-4">Time window: </span>
                <span class="col-8"> {{ job.order_detail.appointment_time }}</span>
              </div>
              <div class="break"></div>
              <div class="row text-left">
                <span class="col-4">Type: </span>
                <span class="col-8"> {{ job.order_detail.movingtype.title }}</span>
              </div>
              <div class="break"></div>
              <div class="row text-left">
                <span class="col-4">Instructions: </span>
                <span class="col-8">
                  {{
                    job.order_detail.instructions
                      ? job.order_detail.instructions
                      : "Not given"
                  }}</span
                >
              </div>
            </b-card>
          </div>
          <div class="col">
            <b-card header="Supplies" class="border-0 shadow text-left mb-3">
              <div class="row">
                <span v-if="job.order_detail.supplies.length > 0">
                  <div
                    v-for="(supply, index) in job.order_detail.supplies"
                    :key="index"
                    class="list"
                  >
                    <span class="col-4">{{ supply.name }}:</span>
                    <span class="col-8"> {{ supply.pivot.number }}</span>
                  </div>
                </span>
                <span v-else>Not selected</span>
              </div>
            </b-card>
            <b-card
              v-if="job.order_detail.items.length > 0"
              header="Items"
              class="border-0 shadow mb-3"
            >
              <div class="row">
                <span>
                  <div
                    v-for="(item, index) in job.order_detail.items"
                    :key="index"
                    class="list"
                  >
                    <span class="col-4">{{ item.name }}:</span>
                    <span class="col-8"> {{ item.pivot.number }}</span>
                  </div>
                </span>
              </div>
            </b-card>
            <b-card header="Price" class="border-0 shadow text-left mb-3">
              <div class="row">
                <span class="col-4"><strong>Total:</strong> </span>
                <span class="col-8"
                  ><strong>${{ job.order_detail.cost }}</strong></span
                >
              </div>
              <div class="row">
                <span class="col-4">Moving cost: </span>
                <span class="col-8">${{ job.order_detail.moving_cost }}</span>
              </div>
              <div class="row">
                <span class="col-4">Travel cost: </span>
                <span class="col-8">${{ job.order_detail.travel_cost }}</span>
              </div>
              <div class="row">
                <span class="col-4">Service fee: </span>
                <span class="col-8">${{ job.order_detail.service_fee }}</span>
              </div>
              <div class="row" v-if="job.order_detail.disposal_fee">
                <span class="col-4">Disposal fee: </span>
                <span class="col-8">${{ job.order_detail.disposal_fee }}</span>
              </div>
              <div class="row">
                <span class="col-4">Tax: </span>
                <span class="col-8">${{ job.order_detail.tax }}</span>
              </div>
              <div class="row" v-if="job.order_detail.tips">
                <span class="col-4">Tips: </span>
                <span class="col-8">${{ job.order_detail.tips }}</span>
              </div>
            </b-card>
            <b-card header="Customer Contacts" class="border-0 shadow text-left">
              <div class="row">
                <span class="col-4">Name: </span>
                <span class="col-8">{{
                  job.order_detail.shipper_contacts.user.name
                }}</span>
              </div>
              <div class="row">
                <span class="col-4">Email: </span>
                <span class="col-8">{{
                  job.order_detail.shipper_contacts.user.email
                }}</span>
              </div>
              <div class="row">
                <span class="col-4">Phone: </span>
                <span class="col-8">{{
                  job.order_detail.shipper_contacts.user.phone
                }}</span>
              </div>
            </b-card>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
      this.$bvModal
        .msgBoxConfirm("Do you want this order to be " + status + " ?")
        .then((value) => {
          if (value) {
            this.confirm(status);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    confirm(status) {
      this.isSubmitting = true;
      this.job["status"] = status;
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
  components: {},
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
