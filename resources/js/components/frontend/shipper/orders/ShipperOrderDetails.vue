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

    <md-card class="no-shadow-bordered" v-if="order">
      <md-card-header>
        <div>
          <div class="md-title md-primary">Order details</div>
          <div class="job-id">
            <span>{{ order.uniqid }}</span> |
            <span>{{ order.pickup_date }}</span>
          </div>
        </div>

        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
      </md-card-header>
      <md-card-content>
        <div class="status">
          <div v-if="order.status == 'Not picked'">
            <Spinner v-if="canceling" />
            <md-button v-else class="md-accent md-raised" @click="confirmDialog = true"
              >Cancel</md-button
            >
          </div>
          <span>Status: {{ order.status }}</span>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">From</h3>
              <div class="md-body-1">
                Address:
                {{ order.addresses[0].formatted_address }}
              </div>

              <div class="md-body-1">
                Floor:
                {{ order.floor_from == null ? "No stairs" : order.floor_from }}
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">To</h3>
              <div class="md-body-1">
                Address:
                {{ order.addresses[1].formatted_address }}
              </div>

              <div class="md-body-1">
                Floor:
                {{ order.floor_to == null ? "No stairs" : order.floor_to }}
              </div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Selected Supplies</h3>
              <div v-if="order.supplies.length > 0">
                <div
                  class="md-body-1"
                  v-for="(supply, index) in order.supplies"
                  :key="index"
                >
                  {{ supply.name }}:
                  {{ supply.pivot.number }}
                </div>
              </div>
              <div v-else class="md-md-body-1">Not selected</div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Contact Details</h3>
              <div class="md-body-1">Contact name: {{ order.contact.name }}</div>

              <div class="md-body-1">Phone: {{ order.contact.phone }}</div>
              <div class="md-body-1">Email: {{ order.contact.email }}</div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">Mover Details</h3>
              <div class="md-body-1">
                Name: {{ order.job_with_status.carrier.last_name }}
              </div>
              <div class="md-body-1">
                Company: {{ order.job_with_status.carrier.company }}
              </div>
              <div class="md-body-1" v-if="order.vehicle">
                Requested vehicle: {{ order.vehicle.name }}
              </div>
              <div class="md-body-1" v-if="order.movernumber">
                Requested number of movers: {{ order.movernumber.number }}
              </div>
            </md-card-content>
          </md-card>

          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Other Information</h3>
              <div class="md-body-1">Pickup date: {{ order.pickup_date }}</div>
              <div class="md-body-1">
                Appointment:
                {{
                  order.src_appointment_time != null
                    ? order.appointment_time
                    : "No selected"
                }}
              </div>
              <div class="md-body-1" v-if="order.movingsize">
                Moving size:
                {{ order.movingsize.title }}
              </div>

              <div class="md-body-1">Instructions: {{ order.instructions }}</div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des" v-if="order.items.length > 0">
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Selected Items</h3>
              <div v-for="item in order.items" :key="item.id">
                <div class="md-body-1">{{ item.name }}: {{ item.pivot.number }}</div>
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">Total Cost</h3>
              <div class="md-body-1">Total: ${{ order.cost }}</div>
            </md-card-content>
          </md-card>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Rate from "../rate/Rate";
import Spinner from "../../../shared/Spinner";
export default {
  name: "orderDetails",
  data: () => ({
    order: null,
    notification: null,
    notificationId: null,
    canceling: false,
    confirmDialog: false,
  }),
  methods: {
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
    onCancel() {},
    onConfirm() {
      this.canceling = true;
      axios
        .put("shipper/orders/" + this.$route.params.id, {
          status: "Canceled",
        })
        .then((res) => {
          this.orderDetails();
          this.canceling = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    refresh() {
      this.rateTogal = false;
    },
  },
  created() {
    this.orderDetails();
    this.notificationId = this.$store.state.shared.notificationId;
  },
  watch: {
    $route() {
      this.notificationId = this.$store.state.shared.notificationId;
      this.orderDetails();
    },
  },
  components: {
    Spinner,
    Rate,
  },
};
</script>

<style lang="scss" scoped>
.no-shadow-bordered {
  margin: 0 20px !important;
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
