<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="confirmDialog"
      md-title="Confirmation"
      md-content="Please confirm your action"
      md-confirm-text="Agree"
      md-cancel-text="Disagree"
      @md-cancel="onCancel"
      @md-confirm="onConfirm"
    />

    <md-card v-if="order" class="outer-card">
      <md-card-header class="head">
        <div class="status">
          <span>Status: {{ order.status }}</span>
          <div class="outer-content">
            <md-button
              v-if="order.status == 'Completed'"
              class="custom-button review"
              @click="review(order.id)"
              >Review</md-button
            >

            <div
              v-if="
                order.movingtype.code == 'appartment' || order.movingtype.code == 'office'
              "
            >
              <Spinner v-if="isSubmitting" />
              <div v-else>
                <md-button
                  :disabled="checkMovingTime(order.pickup_date, order.appointment_time)"
                  class="custom-button"
                  v-bind:class="{
                    inactive: checkMovingTime(order.pickup_date, order.appointment_time),
                  }"
                  @click="(confirmDialog = true), (status = 'edit')"
                  >Edit</md-button
                >
                <md-button
                  :disabled="checkMovingTime(order.pickup_date, order.appointment_time)"
                  class="custom-button"
                  v-bind:class="{
                    inactive: checkMovingTime(order.pickup_date, order.appointment_time),
                  }"
                  @click="(confirmDialog = true), (status = 'cancel')"
                  >Cancel</md-button
                >
              </div>
            </div>
            <div v-else>
              <Spinner v-if="isSubmitting" />
              <div v-else>
                <md-button
                  :disabled="checkItemTime(order.pickup_date, order.appointment_time)"
                  class="custom-button"
                  v-bind:class="{
                    inactive: checkItemTime(order.pickup_date, order.appointment_time),
                  }"
                  @click="(confirmDialog = true), (status = 'edit')"
                  >Edit</md-button
                >
                <md-button
                  :disabled="checkItemTime(order.pickup_date, order.appointment_time)"
                  class="custom-button"
                  v-bind:class="{
                    inactive: checkItemTime(order.pickup_date, order.appointment_time),
                  }"
                  @click="(confirmDialog = true), (status = 'cancel')"
                  >Cancel</md-button
                >
              </div>
            </div>
          </div>
        </div>
      </md-card-header>
      <md-card-content>
        <div class="cols">
          <div class="col">
            <md-card class="col1">
              <md-card-header><span class="md-title">Order</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span>Order: </span>
                  <span>{{ order.uniqid }}</span>
                </div>
                <div class="row">
                  <span>Placed on: </span>
                  <span>{{ formatDate(order.created_at) }}</span>
                </div>
                <div class="row">
                  <span>Pickup location: </span>
                  <span>{{ order.addresses[0].formatted_address }}</span>
                </div>
                <div class="row">
                  <span>Floor: </span>
                  <span v-if="order.floor_from">{{ order.floor_from }}</span>
                  <span v-else>No stairs</span>
                </div>
                <div class="row">
                  <span>Destination: </span>
                  <span>{{ order.addresses[1].formatted_address }}</span>
                </div>
                <div class="row">
                  <span>Floor: </span>
                  <span v-if="order.floor_to">{{ order.floor_to }}</span>
                  <span v-else>No stairs</span>
                </div>
                <div class="row" v-if="order.movingtype.code == 'apartment'">
                  <span>Moving size: </span>
                  <span>{{ order.movingsize.title }}</span>
                </div>
                <div class="row" v-if="order.movingtype.code == 'office'">
                  <span>Office size: </span>
                  <span>{{ order.officesize.title }}</span>
                </div>
                <div class="row" v-if="order.vehicle">
                  <span>Requested vehicle: </span>
                  <span>{{ order.vehicle.name }}</span>
                </div>
                <div class="row" v-if="order.movernumber">
                  <span>Number of movers: </span>
                  <span>{{ order.movernumber.number }}</span>
                </div>
                <div class="row">
                  <span>Schedualed date: </span>
                  <span>{{ order.pickup_date }}</span>
                </div>
                <div class="row">
                  <span>Time window: </span>
                  <span>{{ order.appointment_time }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span>Moving type: </span>
                  <span>{{ order.movingtype.title }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span>Instructions: </span>
                  <span>{{ order.instructions }}</span>
                </div>
              </md-card-content>
            </md-card>
          </div>
          <div class="col">
            <md-card>
              <md-card-header><span class="md-title">Supplies</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span v-if="order.supplies.length > 0">
                    <div
                      v-for="(supply, index) in order.supplies"
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
            <md-card v-if="order.items.length > 0">
              <md-card-header><span class="md-title">Items</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span>
                    <div v-for="(item, index) in order.items" :key="index" class="list">
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
                  <span>Total: </span>
                  <span>${{ order.cost }}</span>
                </div>
                <div class="row">
                  <span>Moving cost: </span>
                  <span>${{ order.moving_cost }}</span>
                </div>
                <div class="row">
                  <span>Travel cost: </span>
                  <span>${{ order.travel_cost }}</span>
                </div>
                <div class="row">
                  <span>Tax: </span>
                  <span>${{ order.tax }}</span>
                </div>
                <div class="row" v-if="order.tips">
                  <span>Tips: </span>
                  <span>${{ order.tips }}</span>
                </div>
              </md-card-content>
            </md-card>
            <md-card>
              <md-card-header><span class="md-title">Mover contact</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span>Name: </span>
                  <span>{{ order.job_with_carrier.carrier_detail.company }}</span>
                </div>
                <div class="row">
                  <span>Email: </span>
                  <span>{{ order.job_with_carrier.carrier_detail.user.email }}</span>
                </div>
                <div class="row">
                  <span>Phone: </span>
                  <span>{{ order.job_with_carrier.carrier_detail.user.phone }}</span>
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
import Rate from "../rate/Rate";
import Spinner from "../../../shared/Spinner";
import services from "../../services/orderSchedualer";
import dateFormatter from "../../services/dateFormatter.js";
export default {
  name: "orderDetails",
  components: {
    Spinner,
    Rate,
  },
  data: () => ({
    order: null,
    notification: null,
    notificationId: null,
    isSubmitting: false,
    confirmDialog: false,
    status: null,
  }),
  watch: {
    $route() {
      this.notificationId = this.$store.state.shared.notificationId;
      this.orderDetails();
    },
  },
  created() {
    this.orderDetails();
    this.notificationId = this.$store.state.shared.notificationId;
  },
  methods: {
    checkMovingTime(date, time) {
      return services.movingExpiration(date, time);
    },
    checkItemTime(date, time) {
      return services.itemExpiration(date, time);
    },
    formatDate(date) {
      return dateFormatter.format(date);
    },
    orderDetails() {
      axios
        .get("shipper/orders/" + this.$route.params.id)
        .then((res) => {
          console.log("details: ", res.data);
          this.order = res.data;
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
          this.$router.replace("../orders");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onCancel() {},
    onConfirm() {
      this.isSubmitting = true;
      if (this.status == "cancel") {
        axios
          .put("shipper/orders/" + this.$route.params.id, {
            status: "Canceled",
            phone: this.order.job_with_carrier.carrier_contact.contact.phone,
            email: this.order.job_with_carrier.carrier_contact.contact.email,
            jobId: this.order.job_with_carrier.id,
          })
          .then((res) => {
            console.log("res: ", res.data);
            this.orderDetails();
            this.isSubmitting = false;
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        this.$router.push("/");
      }
    },
    refresh() {
      this.rateTogal = false;
    },
    review(id) {
      this.$router.push("/review/" + id);
    },
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
    .outer-content {
      display: flex;
      .review {
        margin-right: 10px;
      }
    }
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
