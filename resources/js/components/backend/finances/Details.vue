<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="confirmTogal"
      md-title="Confirmation"
      :md-content="confirmation_text"
      md-confirm-text="Agree"
      md-cancel-text="Disagree"
      @md-cancel="onCancel"
      @md-confirm="onConfirm"
    />

    <md-card v-if="earning" class="outer-card">
      <md-card-header class="head">
        <div class="status">
          <span>Status: {{ earning.status }}</span>
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
                  <span>{{ earning.order_detail.uniqid }}</span>
                </div>
                <div class="row">
                  <span>Placed on: </span>
                  <span>{{ formatDate(earning.order_detail.created_at) }}</span>
                </div>
                <div class="row">
                  <span>Pickup location: </span>
                  <span>{{ earning.order_detail.addresses[0].formatted_address }}</span>
                </div>
                <div class="row">
                  <span>Floor: </span>
                  <span v-if="earning.order_detail.floor_from">{{
                    earning.order_detail.floor_from
                  }}</span>
                  <span v-else>No stairs</span>
                </div>
                <div class="row">
                  <span>Destination: </span>
                  <span>{{ earning.order_detail.addresses[1].formatted_address }}</span>
                </div>
                <div class="row">
                  <span>Floor: </span>
                  <span v-if="earning.order_detail.floor_to">{{
                    earning.order_detail.floor_to
                  }}</span>
                  <span v-else>No stairs</span>
                </div>
                <div
                  class="row"
                  v-if="earning.order_detail.movingtype.code == 'apartment'"
                >
                  <span>Moving size: </span>
                  <span>{{ earning.order_detail.movingsize.title }}</span>
                </div>
                <div class="row" v-if="earning.order_detail.movingtype.code == 'office'">
                  <span>Office size: </span>
                  <span>{{ earning.order_detail.officesize.title }}</span>
                </div>
                <div class="row" v-if="earning.order_detail.vehicle">
                  <span>Requested vehicle: </span>
                  <span>{{ earning.order_detail.vehicle.name }}</span>
                </div>
                <div class="row" v-if="earning.order_detail.movernumber">
                  <span>Number of movers: </span>
                  <span>{{ earning.order_detail.movernumber.number }}</span>
                </div>
                <div class="row">
                  <span>Schedualed date: </span>
                  <span>{{ earning.order_detail.pickup_date }}</span>
                </div>
                <div class="row">
                  <span>Time window: </span>
                  <span>{{ earning.order_detail.appointment_time }}</span>
                </div>

                <div class="break"></div>
                <div class="row">
                  <span>Moving type: </span>
                  <span>{{ earning.order_detail.movingtype.title }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span>Instructions: </span>
                  <span>{{ earning.order_detail.instructions }}</span>
                </div>
              </md-card-content>
            </md-card>
            <md-card>
              <md-card-header><span class="md-title">Supplies</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span v-if="earning.order_detail.supplies.length > 0">
                    <div
                      v-for="(supply, index) in earning.order_detail.supplies"
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
            <md-card v-if="earning.order_detail.items.length > 0">
              <md-card-header><span class="md-title">Items</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span>
                    <div
                      v-for="(item, index) in earning.order_detail.items"
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
                  <span>{{ earning.order_detail.shipper_contacts.user.name }}</span>
                </div>
                <div class="row">
                  <span>Email: </span>
                  <span>{{ earning.order_detail.shipper_contacts.user.email }}</span>
                </div>
                <div class="row">
                  <span>Phone: </span>
                  <span>{{ earning.order_detail.shipper_contacts.user.phone }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span class="md-body-2">Price:</span>
                </div>
                <div class="row">
                  <span>Total: </span>
                  <span>${{ earning.order_detail.cost }}</span>
                </div>
                <div class="row">
                  <span>Moving cost: </span>
                  <span>${{ earning.order_detail.moving_cost }}</span>
                </div>
                <div class="row">
                  <span>Travel cost: </span>
                  <span>${{ earning.order_detail.travel_cost }}</span>
                </div>
                <div class="row">
                  <span>Supplies cost: </span>
                  <span>${{ earning.order_detail.supplies_cost }}</span>
                </div>
                <div class="row" v-if="earning.order_detail.disposal_fee">
                  <span>Disposal fee: </span>
                  <span>${{ earning.order_detail.disposal_fee }}</span>
                </div>
                <div class="row">
                  <span>Tax: </span>
                  <span>${{ earning.order_detail.tax }}</span>
                </div>
                <div class="row" v-if="earning.order_detail.tips">
                  <span>Tips: </span>
                  <span>${{ earning.order_detail.tips }}</span>
                </div>
              </md-card-content>
              <md-card-actions>
                <Spinner v-if="isRefunding" />
                <div v-else>
                  <md-button
                    v-if="earning.status == 'Paid'"
                    class="md-primary"
                    @click="edit('Refunded')"
                    >Refund</md-button
                  >
                </div>
              </md-card-actions>
            </md-card>
            <md-card>
              <md-card-header><span class="md-title">Mover</span></md-card-header>
              <md-card-content>
                <div class="row">
                  <span class="md-body-2">Contacts:</span>
                </div>
                <div class="row">
                  <span>Name: </span>
                  <span>{{
                    earning.order_detail.job_with_carrier.carrier_detail.company
                  }}</span>
                </div>
                <div class="row">
                  <span>Email: </span>
                  <span>{{
                    earning.order_detail.job_with_carrier.carrier_detail.user.email
                  }}</span>
                </div>
                <div class="row">
                  <span>Phone: </span>
                  <span>{{
                    earning.order_detail.job_with_carrier.carrier_detail.user.phone
                  }}</span>
                </div>
                <div class="break"></div>
                <div class="row">
                  <span class="md-body-2">Cost:</span>
                </div>
                <div class="row">
                  <span>Total: </span>
                  <span
                    >${{
                      Math.round(
                        earning.order_detail.cost - earning.order_detail.service_fee
                      ).toFixed(2)
                    }}</span
                  >
                </div>
                <div class="row">
                  <span>Moving cost: </span>
                  <span>${{ earning.order_detail.moving_cost }}</span>
                </div>
                <div class="row">
                  <span>Travel cost: </span>
                  <span>${{ earning.order_detail.travel_cost }}</span>
                </div>
                <div class="row">
                  <span>Supplies cost: </span>
                  <span>${{ earning.order_detail.supplies_cost }}</span>
                </div>
                <div class="row">
                  <span>Service fee: </span>
                  <span>-${{ earning.order_detail.service_fee }}</span>
                </div>
                <div class="row">
                  <span>Tax: </span>
                  <span>${{ earning.paid_gst }}</span>
                </div>
                <div class="row">
                  <span>Tips: </span>
                  <span
                    >${{
                      earning.order_detail.tips ? earning.order_detail.tips : 0
                    }}</span
                  >
                </div>
                <div class="row" v-if="earning.order_detail.tips">
                  <span>Tips: </span>
                  <span>${{ earning.order_detail.tips }}</span>
                </div>
              </md-card-content>
              <md-card-actions>
                <Spinner v-if="isSubmitting" />
                <div v-else>
                  <md-button
                    v-if="earning.status == 'Unpaid'"
                    class="md-primary"
                    @click="edit('Paid')"
                    >Pay</md-button
                  >
                </div>
              </md-card-actions>
            </md-card>
          </div>
        </div>
      </md-card-content>
    </md-card>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import Rate from "../../frontend/shipper/rate/Rate";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import dateFormatter from "../../frontend/services/dateFormatter.js";
export default {
  name: "EarningDetails",
  components: {
    Spinner,
    Snackbar,
    Rate,
  },
  data: () => ({
    earning: null,
    isSubmitting: false,
    isRefunding: false,
    confirmTogal: false,
    status: null,
    confirmation_text: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
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
      this.confirmation_text = "Do you want this order to be " + status + " ?";
      this.status = status;
      this.confirmTogal = true;
    },
    onCancel() {},
    onConfirm() {
      this.earning["status"] = this.status;
      if (this.status == "Refunded") {
        this.isRefunding = true;
        axios
          .put("admin/refunds/" + this.$route.params.id, this.earning)
          .then((res) => {
            console.log("refunded: ", res.data);
            this.details();
            this.isRefunding = false;
            this.snackbar.message = res.data;
            this.snackbar.statusCode = 200;
            this.snackbar.show = true;
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
            this.snackbar.message = res.data;
            this.snackbar.statusCode = 200;
            this.snackbar.show = true;
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
    min-height: 545px;
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
