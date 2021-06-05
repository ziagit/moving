<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="confirmDialog"
      md-title="Confirmation"
      :md-content="confirmation_text"
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
            <div>
              <Spinner v-if="isSubmitting" />
              <div v-else>
                <md-button class="custom-button" @click="edit('Edited')">Edit</md-button>
                <md-button class="custom-button" @click="edit('Accepted')"
                  >Accept</md-button
                >
                <md-button class="custom-button" @click="edit('Canceled')"
                  >Cancel</md-button
                >
                <md-button class="custom-button" @click="edit('Declined')"
                  >Decline</md-button
                >
                <md-button class="custom-button" @click="edit('Completed')"
                  >Complete</md-button
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
          </div>
          <div class="col">
            <md-card>
              <md-card-header><span class="md-title">Customer</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span class="md-body-2">Contacts:</span>
                </div>
                <div class="row">
                  <span>Name: </span>
                  <span>{{ order.shipper_contacts.user.name }}</span>
                </div>
                <div class="row">
                  <span>Email: </span>
                  <span>{{ order.shipper_contacts.user.email }}</span>
                </div>
                <div class="row">
                  <span>Phone: </span>
                  <span>{{ order.shipper_contacts.user.phone }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span class="md-body-2">Cost:</span>
                </div>
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
                  <span>Supplies cost: </span>
                  <span>${{ order.supplies_cost }}</span>
                </div>
                <div class="row" v-if="order.disposal_fee">
                  <span>Disposal fee: </span>
                  <span>${{ order.disposal_fee }}</span>
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
              <md-card-header><span class="md-title">Mover</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span class="md-body-2">Contacts:</span>
                </div>
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
                <div class="break"></div>
                <div class="row">
                  <span class="md-body-2">Price:</span>
                </div>
                <div class="row">
                  <span>Total: </span>
                  <span
                    >${{ Math.round(order.cost - order.service_fee).toFixed(2) }}</span
                  >
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
                  <span>Supplies cost: </span>
                  <span>${{ order.supplies_cost }}</span>
                </div>
                <div class="row">
                  <span>Service fee: </span>
                  <span>-${{ order.service_fee }}</span>
                </div>

                <div class="row">
                  <span>Tax: </span>
                  <span>${{ order.tax }}</span>
                </div>
                <div class="row">
                  <span>Tips: </span>
                  <span>${{ order.tips ? order.tips : 0 }}</span>
                </div>
                <div class="row" v-if="order.tips">
                  <span>Tips: </span>
                  <span>${{ order.tips }}</span>
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
import Rate from "../../frontend/shipper/rate/Rate";
import Spinner from "../../shared/Spinner";
import dateFormatter from "../../frontend/services/dateFormatter.js";
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
    confirmation_text: null,
    distance: null,
    duration: null,
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
    orderDetails() {
      axios
        .get("admin/orders/" + this.$route.params.id)
        .then((res) => {
          console.log("details: ", res.data);
          this.order = res.data;
          this.getDistance(
            res.data.addresses[0].formatted_address,
            res.data.addresses[1].formatted_address
          );
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
    edit(status) {
      this.confirmation_text = "Do you want this order to be " + status + " ?";
      this.status = status;
      this.confirmDialog = true;
    },
    onCancel() {},
    onConfirm() {
      if (this.status == "Edited") {
        this.$router.push("/");
      } else {
        this.isSubmitting = true;
        this.order["status"] = this.status;
        axios
          .put("admin/orders/" + this.$route.params.id, this.order)
          .then((res) => {
            console.log("res: ", res.data);
            this.orderDetails();
            this.isSubmitting = false;
          })
          .catch((err) => {
            console.log(err);
          });
      }
    },
    refresh() {
      this.rateTogal = false;
    },
    review(id) {
      this.$router.push("/review/" + id);
    },
    formatDate(date) {
      return dateFormatter.format(date);
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
    min-height: 484px;
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
