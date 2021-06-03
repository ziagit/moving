<template>
  <md-card class="no-shadow-bordered container">
    <md-card-header>
      <div>
        <div class="md-title">Order Details</div>
        <div v-if="dataLoaded" class="job-id">
          <span>{{ order.uniqid }}</span> |
          <span>{{ formatedDate }}</span>
        </div>
      </div>

      <md-button @click="$router.back()" class="md-icon-button close-btn">
        <md-icon>close</md-icon>
        <md-tooltip>Cancel</md-tooltip>
      </md-button>
    </md-card-header>
    <md-card-content v-if="dataLoaded">
      <div class="status">
        <span>Status: {{ order.status }}</span>
      </div>
      <div class="src-des">
        <md-card class="src">
          <md-card-content>
            <h3 class="md-subheading md-primary">From</h3>
            <div class="body-1">Address: {{ order.addresses[0].formatted_address }}</div>
            <div class="md-body-1" v-if="order.floor_from">
              Floor: {{ order.floor_from }}
            </div>
          </md-card-content>
        </md-card>
        <md-card class="des">
          <md-card-content>
            <h3 class="md-subheading md-primary">To</h3>
            <div class="body-1">Address: {{ order.addresses[1].formatted_address }}</div>

            <div class="md-body-1" v-if="order.floor_to">Floor: {{ order.floor_to }}</div>
          </md-card-content>
        </md-card>
      </div>
      <div class="src-des">
        <md-card class="src">
          <md-card-content>
            <h3 class="md-subheading md-primary">Selected Supplies</h3>
            <div v-if="order.supplies.length > 0">
              <div v-for="item in order.supplies" :key="item.id">
                <div class="body-1">{{ item.name }}: {{ item.pivot.number }}</div>
              </div>
            </div>
            <div v-else>Not selected</div>
          </md-card-content>
        </md-card>
        <md-card class="des">
          <md-card-content>
            <h3 class="md-subheading md-primary">Contact Details</h3>
            <div class="md-body-1" v-if="order.contact">
              Name: {{ order.contact.name }}
            </div>
            <div class="md-body-1" v-if="order.contact">
              Phone: {{ order.contact.phone }}
            </div>
            <div class="md-body-1" v-if="order.contact">
              Email: {{ order.contact.email }}
            </div>
          </md-card-content>
        </md-card>
      </div>
      <div class="src-des">
        <md-card class="src">
          <md-card-content>
            <h3 class="md-subheading md-primary">Other Informations</h3>
            <div class="body-1">Pickup date: {{ order.pickup_date }}</div>
            <div class="body-1">Apointment time: {{ order.appointment_time }}</div>
            <div class="body-1">Moving type: {{ order.movingtype.title }}</div>
            <div class="body-1" v-if="order.movingtype == 'office'">
              Office size: {{ order.officesize.title }}
            </div>
            <div class="body-1" v-if="order.movingtype == 'apartment'">
              Moving size: {{ order.movingsize.title }}
            </div>
          </md-card-content>
        </md-card>
        <md-card class="des">
          <md-card-content>
            <h3 class="md-subheading md-primary">Selected Mover</h3>
            <div class="body-1">
              Name: {{ order.job_with_carrier.carrier.first_name }}
            </div>
            <div class="body-1" v-if="order.vehicle">
              Requested vehicle: {{ order.vehicle.name }}
            </div>
            <div class="body-1" v-if="order.movernumber">
              Number of requested movers: {{ order.movernumber.number }}
            </div>
            <div class="body-1">Cost: ${{ order.cost }}</div>
          </md-card-content>
        </md-card>
      </div>
      <div class="src-des" v-if="order.items.length > 0">
        <md-card class="src">
          <md-card-content>
            <h3 class="md-subheading md-primary">Selected Items</h3>
            <div v-for="item in order.items" :key="item.id">
              <div class="body-1">{{ item.name }} : {{ item.pivot.number }}</div>
            </div>
          </md-card-content>
        </md-card>
      </div>
    </md-card-content>
    <md-card-actions></md-card-actions>
  </md-card>
</template>

<script>
import axios from "axios";
import functions from "../../../frontend/services/functions";
export default {
  name: "orderDetails",
  props: ["orderId"],
  data: () => ({
    order: null,
    active: false,
    hasHistory: false,
    notification: null,
    notificationId: null,
    dataLoaded: false,
    status: [],
    selectedStatus: null,
    formatedDate: null,
    dataLoading: false,
    emails: {
      src: null,
      des: null,
    },
  }),
  methods: {
    getDetails() {
      axios
        .get("admin/orders/" + this.$route.params.id)
        .then((res) => {
          console.log("order details ", res.data);
          this.order = res.data;
          this.formatedDate = functions.myDateFormat(this.order.created_at);
          if (this.order != null) {
            this.dataLoaded = true;
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
          console.log(res.data);
          this.$router.replace("../orders");
        })
        .catch((err) => {
          console.log(err);
        });
    },
    markAsReceived() {
      this.dataLoading = true;
      axios
        .post("shipper/orders/" + this.$route.params.id, {
          jobId: this.order.job_with_status.id,
        })
        .then((res) => {
          this.order = res.data;
          this.dataLoading = false;
          console.log("updated order: ", res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {
    this.getDetails();
    this.notificationId = this.$store.state.shared.notificationId;
  },
  watch: {
    $route() {
      this.notificationId = this.$store.state.shared.notificationId;
      this.orderDetails();
    },
  },
};
</script>

<style lang="scss" scoped>
.container {
  min-width: 900px;
}
.md-card {
  text-align: center;
  padding: 30px;

  .status {
    display: flex;
    justify-content: flex-end;
    align-items: center;

    .delivered {
      color: green !important;
    }
  }

  .md-card {
    margin: 5px;
  }

  .src,
  .des,
  .items,
  .shipment {
    box-shadow: none;
    border: 1px solid rgb(241, 241, 241);
    text-align: left;
  }

  .shipment {
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
}
</style>
