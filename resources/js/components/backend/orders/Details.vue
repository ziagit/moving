<template>
  <div class="container">
    <div v-if="order" class="mt-5">
      <div class="d-flex justify-content-between align-items-center">
        <span
          >Status: <b-badge pill variant="dark">{{ order.status }}</b-badge></span
        >
        <div>
          <b-spinner variant="primary" v-if="isSubmitting" />
          <b-button-group v-else>
            <b-button variant="primary" @click="edit('Edited')">Edit</b-button>
            <b-button variant="secondary" @click="edit('Accepted')">Accept</b-button>
            <b-button variant="danger" @click="edit('Canceled')">Cancel</b-button>
            <b-button variant="warning" @click="edit('Declined')">Decline</b-button>
            <b-button variant="success" @click="edit('Completed')">Complete</b-button>
          </b-button-group>
        </div>
      </div>
      <div class="row d-flex justify-content-between">
        <div class="col-md-6">
          <b-card class="border-0 shadow mb-3" header="Order Details">
            <div class="row">
              <span class="col-3">Order: </span>
              <span class="col-6">{{ order.uniqid }}</span>
            </div>
            <div class="row">
              <span class="col-3">Placed on: </span>
              <span class="col-6">{{ formatDate(order.created_at) }}</span>
            </div>
            <div class="row">
              <span class="col-3">Pickup location: </span>
              <span class="col-6">{{ order.addresses[0].formatted_address }}</span>
            </div>
            <div class="row">
              <span class="col-3">Floor: </span>
              <span class="col-6" v-if="order.floor_from">{{ order.floor_from }}</span>
              <span class="col-6" v-else>No stairs</span>
            </div>
            <div class="row">
              <span class="col-3">Destination: </span>
              <span class="col-6">{{ order.addresses[1].formatted_address }}</span>
            </div>
            <div class="row">
              <span class="col-3">Floor: </span>
              <span class="col-6" v-if="order.floor_to">{{ order.floor_to }}</span>
              <span class="col-6" v-else>No stairs</span>
            </div>
            <div class="row" v-if="order.movingtype.code == 'apartment'">
              <span class="col-3">Moving size: </span>
              <span class="col-6">{{ order.movingsize.title }}</span>
            </div>
            <div class="row" v-if="order.movingtype.code == 'office'">
              <span class="col-3">Office size: </span>
              <span class="col-6">{{ order.officesize.title }}</span>
            </div>
            <div class="row" v-if="order.vehicle">
              <span class="col-3">Requested vehicle: </span>
              <span class="col-6">{{ order.vehicle.name }}</span>
            </div>
            <div class="row" v-if="order.movernumber">
              <span class="col-3">Number of movers: </span>
              <span class="col-6">{{ order.movernumber.number }}</span>
            </div>
            <div class="row">
              <span class="col-3">Schedualed date: </span>
              <span class="col-6">{{ order.pickup_date }}</span>
            </div>
            <div class="row">
              <span class="col-3">Time window: </span>
              <span class="col-6">{{ order.appointment_time }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3">Moving type: </span>
              <span class="col-6">{{ order.movingtype.title }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3">Instructions: </span>
              <span class="col-6">{{ order.instructions }}</span>
            </div>
          </b-card>
          <b-card class="mt-3 shadow border-0" header="Supplies">
            <div class="row">
              <span v-if="order.supplies.length > 0">
                <div v-for="(supply, index) in order.supplies" :key="index" class="list">
                  <span class="col-3">{{ supply.name }}:</span>
                  <span class="col-6"> {{ supply.pivot.number }}</span>
                </div>
              </span>
              <span class="col-6" v-else>Not selected</span>
            </div>
          </b-card>
          <b-card v-if="order.items.length > 0" header="Items" class="shadow border-0">
            <div class="row">
              <span>
                <div v-for="(item, index) in order.items" :key="index" class="list">
                  <span class="col-3">{{ item.name }}:</span>
                  <span class="col-6"> {{ item.pivot.number }}</span>
                </div>
              </span>
            </div>
          </b-card>
        </div>
        <div class="col-md-6">
          <b-card header="Customer" class="mb-3 border-0 shadow">
            <div class="row">
              <span class="col-3"><b>Contacts:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Name: </span>
              <span class="col-6">{{ order.shipper_contacts.user.name }}</span>
            </div>
            <div class="row">
              <span class="col-3">Email: </span>
              <span class="col-6">{{ order.shipper_contacts.user.email }}</span>
            </div>
            <div class="row">
              <span class="col-3">Phone: </span>
              <span class="col-6">{{ order.shipper_contacts.user.phone }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3"><b>Price:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Total: </span>
              <span class="col-6">${{ order.cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Moving cost: </span>
              <span class="col-6">${{ order.moving_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Travel cost: </span>
              <span class="col-6">${{ order.travel_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Supplies cost: </span>
              <span class="col-6">${{ order.supplies_cost }}</span>
            </div>
            <div class="row" v-if="order.disposal_fee">
              <span class="col-3">Disposal fee: </span>
              <span class="col-6">${{ order.disposal_fee }}</span>
            </div>
            <div class="row">
              <span class="col-3">Tax: </span>
              <span class="col-6">${{ order.tax }}</span>
            </div>
            <div class="row" v-if="order.tips">
              <span class="col-3">Tips: </span>
              <span class="col-6">${{ order.tips }}</span>
            </div>
          </b-card>
          <b-card header="Mover" class="border-0 shadow mb-3">
            <div class="row">
              <span class="col-3"><b>Contacts:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Name: </span>
              <span class="col-6">{{
                order.job_with_carrier.carrier_detail.company
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Email: </span>
              <span class="col-6">{{
                order.job_with_carrier.carrier_detail.user.email
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Phone: </span>
              <span class="col-6">{{
                order.job_with_carrier.carrier_detail.user.phone
              }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3"><b>Cost:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Total: </span>
              <span class="col-6"
                >${{ Math.round(order.cost - order.service_fee).toFixed(2) }}</span
              >
            </div>
            <div class="row">
              <span class="col-3">Moving cost: </span>
              <span class="col-6">${{ order.moving_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Travel cost: </span>
              <span class="col-6">${{ order.travel_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Supplies cost: </span>
              <span class="col-6">${{ order.supplies_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Service fee: </span>
              <span class="col-6">-${{ order.service_fee }}</span>
            </div>

            <div class="row">
              <span class="col-3">Tax: </span>
              <span class="col-3">${{ order.tax }}</span>
            </div>
            <div class="row">
              <span class="col-3">Tips: </span>
              <span class="col-6">${{ order.tips ? order.tips : 0 }}</span>
            </div>
            <div class="row" v-if="order.tips">
              <span class="col-3">Tips: </span>
              <span class="col-6">${{ order.tips }}</span>
            </div>
          </b-card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Rate from "../../frontend/shipper/rate/Rate";
import dateFormatter from "../../frontend/services/dateFormatter.js";
export default {
  name: "orderDetails",
  components: {
    Rate,
  },
  data: () => ({
    order: null,
    notification: null,
    notificationId: null,
    isSubmitting: false,
    confirmDialog: false,
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
      if (status == "Edited") {
        this.$router.push("/");
      } else {
        this.isSubmitting = true;
        this.order["status"] = status;
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
    formatDate(date) {
      return dateFormatter.format(date);
    },
  },
};
</script>

<style lang="scss" scoped></style>
