<template>
  <div>
    <div v-if="order">
      <div class="status d-flex justify-content-between">
        <span
          >Status: <b-badge pill variant="dark">{{ order.status }}</b-badge></span
        >
        <b-button-group>
          <b-button
            v-if="order.status == 'Completed'"
            variant="primary"
            @click="review(order.id)"
            >Review</b-button
          >
          <div
            v-if="
              order.movingtype.code == 'appartment' || order.movingtype.code == 'office'
            "
          >
            <b-spinner variant="primary" v-if="isSubmitting" />
            <div v-else>
              <b-button
                :disabled="
                  checkMovingTime(order.pickup_date, order.appointment_time) ||
                  order.status == 'Canceled'
                "
                variant="success"
                @click="edit('Edited')"
                >Edit</b-button
              >
              <b-button
                :disabled="
                  checkMovingTime(order.pickup_date, order.appointment_time) ||
                  order.status != 'New'
                "
                variant="danger"
                @click="edit('Canceled')"
                >Cancel</b-button
              >
            </div>
          </div>
          <div v-else>
            <b-spinner variant="primary" v-if="isSubmitting" />
            <div v-else>
              <b-button
                :disabled="
                  checkItemTime(order.pickup_date, order.appointment_time) ||
                  order.status == 'Canceled'
                "
                variant="primary"
                @click="edit('Edited')"
                >Edit</b-button
              >
              <b-button
                :disabled="
                  checkItemTime(order.pickup_date, order.appointment_time) ||
                  order.status != 'New'
                "
                variant="danger"
                @click="edit('Canceled')"
                >Cancel</b-button
              >
            </div>
          </div>
        </b-button-group>
      </div>
      <div class="row">
        <div class="w-50">
          <b-card class="border-0 shadow text-left" header="Order">
            <div class="row">
              <span class="col-4">Order: </span>
              <span class="col-8">{{ order.uniqid }}</span>
            </div>
            <div class="row">
              <span class="col-4">Placed on: </span>
              <span class="col-8">{{ formatDate(order.created_at) }}</span>
            </div>
            <div class="row">
              <span class="col-4">Pickup location: </span>
              <span class="col-8">{{ order.addresses[0].formatted_address }}</span>
            </div>
            <div class="row">
              <span class="col-4">Floor: </span>
              <span class="col-8" v-if="order.floor_from">{{ order.floor_from }}</span>
              <span class="col-8" v-else>No stairs</span>
            </div>
            <div class="row">
              <span class="col-4">Destination: </span>
              <span class="col-8">{{ order.addresses[1].formatted_address }}</span>
            </div>
            <div class="row">
              <span class="col-4">Floor: </span>
              <span class="col-8" v-if="order.floor_to">{{ order.floor_to }}</span>
              <span class="col-8" v-else>No stairs</span>
            </div>
            <div class="row" v-if="order.movingtype.code == 'apartment'">
              <span class="col-4">Moving size: </span>
              <span class="col-8">{{ order.movingsize.title }}</span>
            </div>
            <div class="row" v-if="order.movingtype.code == 'office'">
              <span class="col-4">Office size: </span>
              <span class="col-8">{{ order.officesize.title }}</span>
            </div>
            <div class="row" v-if="order.vehicle">
              <span class="col-4">Requested vehicle: </span>
              <span class="col-8">{{ order.vehicle.name }}</span>
            </div>
            <div class="row" v-if="order.movernumber">
              <span class="col-4">Number of movers: </span>
              <span class="col-8">{{ order.movernumber.number }}</span>
            </div>
            <div class="row">
              <span class="col-4">Schedualed date: </span>
              <span class="col-8">{{ order.pickup_date }}</span>
            </div>
            <div class="row">
              <span class="col-4">Time window: </span>
              <span class="col-8">{{ order.appointment_time }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-4">Moving type: </span>
              <span class="col-8">{{ order.movingtype.title }}</span>
            </div>
            <div class="row mt-1">
              <span class="col-4">Instructions: </span>
              <span class="col-8">{{ order.instructions }}</span>
            </div>
          </b-card>
        </div>
        <div class="w-50">
          <b-card header="Supplies" class="border-0 shadow text-left ml-2 mb-2">
            <div class="row">
              <span v-if="order.supplies.length > 0">
                <div v-for="(supply, index) in order.supplies" :key="index" class="list">
                  <span class="col-4">{{ supply.name }}:</span>
                  <span class="col-8"> {{ supply.pivot.number }}</span>
                </div>
              </span>
              <span class="col-4" v-else>Not selected</span>
            </div>
          </b-card>
          <b-card
            v-if="order.items.length > 0"
            header="Items"
            class="border-0 shadow text-left ml-2 mb-2"
          >
            <div class="row">
              <span>
                <div v-for="(item, index) in order.items" :key="index" class="list">
                  <span class="col-4">{{ item.name }}:</span>
                  <span class="col-8"> {{ item.pivot.number }}</span>
                </div>
              </span>
            </div>
          </b-card>
          <b-card header="Price" class="border-0 shadow text-left ml-2 mb-2">
            <div class="row">
              <span class="col-4">Total: </span>
              <span class="col-8">${{ order.cost }}</span>
            </div>
            <div class="row">
              <span class="col-4">Moving cost: </span>
              <span class="col-8">${{ order.moving_cost }}</span>
            </div>
            <div class="row">
              <span class="col-4">Travel cost: </span>
              <span class="col-8">${{ order.travel_cost }}</span>
            </div>
            <div class="row">
              <span class="col-4">Tax: </span>
              <span class="col-8">${{ order.tax }}</span>
            </div>
            <div class="row" v-if="order.tips">
              <span class="col-4">Tips: </span>
              <span class="col-8">${{ order.tips }}</span>
            </div>
          </b-card>
          <b-card class="border-0 shadow text-left ml-2 mb-2" header="Mover Contacts">
            <div class="row">
              <span class="col-4">Name: </span>
              <span class="col-8">{{
                order.job_with_carrier.carrier_detail.company
              }}</span>
            </div>
            <div class="row">
              <span class="col-4">Email: </span>
              <span class="col-8">{{
                order.job_with_carrier.carrier_detail.user.email
              }}</span>
            </div>
            <div class="row">
              <span class="col-4">Phone: </span>
              <span class="col-8">{{
                order.job_with_carrier.carrier_detail.user.phone
              }}</span>
            </div>
          </b-card>
        </div>
      </div>
    </div>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import Rate from "../rate/Rate";
import Toaster from "../../../shared/Toaster";
import services from "../../services/orderSchedualer";
import builder from "../../services/builder";
import dateFormatter from "../../services/dateFormatter.js";
export default {
  name: "orderDetails",
  components: {
    Toaster,
    Rate,
  },
  data: () => ({
    confirmation_text: null,
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
          console.log("order details ", res.data);
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
      if (status == "Canceled") {
        axios
          .put("shipper/orders/" + this.$route.params.id, {
            status: status,
            phone: this.order.job_with_carrier.carrier_detail.user.phone,
            email: this.order.job_with_carrier.carrier_detail.user.email,
            jobId: this.order.job_with_carrier.id,
          })
          .then((res) => {
            this.$refs.toaster.show(
              "success",
              "b-toaster-top-right",
              "Success",
              res.data
            );
            this.orderDetails();
            this.isSubmitting = false;
          })
          .catch((err) => {
            console.log(err);
          });
      } else {
        builder.editOrder(this.order);
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
/* .outer-card {
  box-shadow: none;
  .head {
    margin: 0 !important;
    padding: 10px 25px;
  }
} */
/* .cols {
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
} */

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
