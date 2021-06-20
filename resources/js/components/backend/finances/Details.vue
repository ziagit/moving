<template>
  <div class="container">
    <div v-if="earning" class="mt-5 mb-5">
      <div class="status">
        <span
          >Status: <b-badge pill variant="dark">{{ earning.status }}</b-badge></span
        >
      </div>
      <div class="row">
        <div class="col-md-6">
          <b-card class="border-0 shadow mb-3" header="Order">
            <div class="row">
              <span class="col-3">Order: </span>
              <span class="col-6">{{ earning.order_detail.uniqid }}</span>
            </div>
            <div class="row">
              <span class="col-3">Placed on: </span>
              <span class="col-6">{{ formatDate(earning.order_detail.created_at) }}</span>
            </div>
            <div class="row">
              <span class="col-3">Pickup location: </span>
              <span class="col-6">{{
                earning.order_detail.addresses[0].formatted_address
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Floor: </span>
              <span class="col-6" v-if="earning.order_detail.floor_from">{{
                earning.order_detail.floor_from
              }}</span>
              <span class="col-6" v-else>No stairs</span>
            </div>
            <div class="row">
              <span class="col-3">Destination: </span>
              <span class="col-6">{{
                earning.order_detail.addresses[1].formatted_address
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Floor: </span>
              <span class="col-6" v-if="earning.order_detail.floor_to">{{
                earning.order_detail.floor_to
              }}</span>
              <span class="col-6" v-else>No stairs</span>
            </div>
            <div class="row" v-if="earning.order_detail.movingtype.code == 'apartment'">
              <span class="col-3">Moving size: </span>
              <span class="col-6">{{ earning.order_detail.movingsize.title }}</span>
            </div>
            <div class="row" v-if="earning.order_detail.movingtype.code == 'office'">
              <span class="col-3">Office size: </span>
              <span class="col-6">{{ earning.order_detail.officesize.title }}</span>
            </div>
            <div class="row" v-if="earning.order_detail.vehicle">
              <span class="col-3">Requested vehicle: </span>
              <span class="col-6">{{ earning.order_detail.vehicle.name }}</span>
            </div>
            <div class="row" v-if="earning.order_detail.movernumber">
              <span class="col-3">Number of movers: </span>
              <span class="col-6">{{ earning.order_detail.movernumber.number }}</span>
            </div>
            <div class="row">
              <span class="col-3">Schedualed date: </span>
              <span class="col-6">{{ earning.order_detail.pickup_date }}</span>
            </div>
            <div class="row">
              <span class="col-3">Time window: </span>
              <span class="col-6">{{ earning.order_detail.appointment_time }}</span>
            </div>

            <div class="break"></div>
            <div class="row">
              <span class="col-3">Moving type: </span>
              <span class="col-6">{{ earning.order_detail.movingtype.title }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3">Instructions: </span>
              <span class="col-6">{{ earning.order_detail.instructions }}</span>
            </div>
          </b-card>
          <b-card header="Supplies" class="border-0 shadow mb-3">
            <div class="row">
              <span v-if="earning.order_detail.supplies.length > 0">
                <div
                  v-for="(supply, index) in earning.order_detail.supplies"
                  :key="index"
                  class="list"
                >
                  <span class="col-3">{{ supply.name }}:</span>
                  <span class="col-6"> {{ supply.pivot.number }}</span>
                </div>
              </span>
              <span class="col-6" v-else>Not selected</span>
            </div>
          </b-card>
          <b-card
            v-if="earning.order_detail.items.length > 0"
            header="Items"
            class="border-0 shadow mb-3"
          >
            <div class="row">
              <span>
                <div
                  v-for="(item, index) in earning.order_detail.items"
                  :key="index"
                  class="list"
                >
                  <span class="col-3">{{ item.name }}:</span>
                  <span class="col-6"> {{ item.pivot.number }}</span>
                </div>
              </span>
            </div>
          </b-card>
        </div>
        <div class="col-md-6">
          <b-card header="Customer" class="shadow border-0 mb-3">
            <div class="row">
              <span class="col-3"><b>Contacts:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Name: </span>
              <span class="col-6">{{
                earning.order_detail.shipper_contacts.user.name
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Email: </span>
              <span class="col-6">{{
                earning.order_detail.shipper_contacts.user.email
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Phone: </span>
              <span class="col-6">{{
                earning.order_detail.shipper_contacts.user.phone
              }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3"><b>Price:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Total: </span>
              <span class="col-6">${{ earning.order_detail.cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Moving cost: </span>
              <span class="col-6">${{ earning.order_detail.moving_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Travel cost: </span>
              <span class="col-6">${{ earning.order_detail.travel_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Supplies cost: </span>
              <span class="col-6">${{ earning.order_detail.supplies_cost }}</span>
            </div>
            <div class="row" v-if="earning.order_detail.disposal_fee">
              <span class="col-3">Disposal fee: </span>
              <span class="col-6">${{ earning.order_detail.disposal_fee }}</span>
            </div>
            <div class="row">
              <span class="col-3">Tax: </span>
              <span class="col-6">${{ earning.order_detail.tax }}</span>
            </div>
            <div class="row" v-if="earning.order_detail.tips">
              <span class="col-3">Tips: </span>
              <span class="col-6">${{ earning.order_detail.tips }}</span>
            </div>
            <div class="mt-3 text-right">
              <b-spinner variant="primary" v-if="isRefunding" />
              <div v-else>
                <b-button
                  v-if="earning.status == 'Paid'"
                  variant="primary"
                  @click="edit('Refunded')"
                  >Refund</b-button
                >
              </div>
            </div>
          </b-card>
          <b-card class="shadow border-0 mb-3" header="Mover">
            <div class="row">
              <span class="col-3"><b>Contacts:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Name: </span>
              <span class="col-6">{{
                earning.order_detail.job_with_carrier.carrier_detail.company
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Email: </span>
              <span class="col-6">{{
                earning.order_detail.job_with_carrier.carrier_detail.user.email
              }}</span>
            </div>
            <div class="row">
              <span class="col-3">Phone: </span>
              <span class="col-6">{{
                earning.order_detail.job_with_carrier.carrier_detail.user.phone
              }}</span>
            </div>
            <div class="break"></div>
            <div class="row">
              <span class="col-3"><b>Cost:</b></span>
            </div>
            <div class="row">
              <span class="col-3">Total: </span>
              <span class="col-6"
                >${{
                  Math.round(
                    earning.order_detail.cost - earning.order_detail.service_fee
                  ).toFixed(2)
                }}</span
              >
            </div>
            <div class="row">
              <span class="col-3">Moving cost: </span>
              <span class="col-6">${{ earning.order_detail.moving_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Travel cost: </span>
              <span class="col-6">${{ earning.order_detail.travel_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Supplies cost: </span>
              <span class="col-6">${{ earning.order_detail.supplies_cost }}</span>
            </div>
            <div class="row">
              <span class="col-3">Service fee: </span>
              <span class="col-6">-${{ earning.order_detail.service_fee }}</span>
            </div>
            <div class="row">
              <span class="col-3">Tax: </span>
              <span class="col-6">${{ earning.paid_gst }}</span>
            </div>
            <div class="row">
              <span class="col-3">Tips: </span>
              <span class="col-6"
                >${{ earning.order_detail.tips ? earning.order_detail.tips : 0 }}</span
              >
            </div>
            <div class="row" v-if="earning.order_detail.tips">
              <span class="col-3">Tips: </span>
              <span class="col-6">${{ earning.order_detail.tips }}</span>
            </div>
            <div class="mt-3 text-right">
              <b-spinner variant="primary" v-if="isSubmitting" />
              <div v-else>
                <b-button
                  v-if="earning.status == 'Unpaid'"
                  variant="primary"
                  @click="edit('Paid')"
                  >Pay</b-button
                >
              </div>
            </div>
          </b-card>
        </div>
      </div>
    </div>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import Rate from "../../frontend/shipper/rate/Rate";
import dateFormatter from "../../frontend/services/dateFormatter.js";
import Toaster from "../../shared/Toaster.vue";
export default {
  name: "EarningDetails",
  components: {
    Toaster,
    Rate,
  },
  data: () => ({
    earning: null,
    isSubmitting: false,
    isRefunding: false,
    confirmTogal: false,
    status: null,
    confirmation_text: null,
  }),
  created() {
    this.details();
  },
  methods: {
    details() {
      axios
        .get("admin/earnings/" + this.$route.params.id)
        .then((res) => {
          console.log("details: ", res.data);
          this.earning = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    edit(status) {
      this.$bvModal
        .msgBoxConfirm("Do you want this account to be " + status + "?")
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
      this.earning["status"] = status;
      if (status == "Refunded") {
        this.isRefunding = true;
        axios
          .put("admin/refunds/" + this.$route.params.id, this.earning)
          .then((res) => {
            console.log("refunded: ", res.data);
            this.details();
            this.isRefunding = false;
            this.$refs.toaster.show(
              "success",
              "b-toaster-top-center",
              "Payment",
              `${res.data}`
            );
          })
          .catch((err) => {
            console.log(err.response);
          });
      } else {
        this.isSubmitting = true;
        axios
          .put("admin/payouts/" + this.$route.params.id, this.earning)
          .then((res) => {
            console.log("paid: ", res.data);
            this.details();
            this.isSubmitting = false;
            this.$refs.toaster.show(
              "success",
              "b-toaster-top-center",
              "Payment",
              `${res.data}`
            );
          })
          .catch((err) => {
            console.log(err.response);
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
