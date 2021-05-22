<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="confirmDialog"
      md-title="Confirmation"
      md-content="Please confirm the payment"
      md-confirm-text="Ok"
      md-cancel-text="Cancel"
      @md-cancel="onCancel"
      @md-confirm="onConfirm"
    />
    <md-card class="no-shadow-bordered" v-if="earning != null">
      <md-card-header>
        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <div>
          <div class="md-title md-primary">Details</div>
          <div class="earning-id">
            <span>{{ earning.order_detail.uniqid }}</span> |
            <span>{{ formatter(earning.created_at) }}</span>
          </div>
        </div>
      </md-card-header>

      <md-card-content>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">From</h3>
              <div class="body-1">
                {{ earning.order_detail.addresses[0].formatted_address }}
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <md-card-content>
              <h3 class="md-subheading md-primary">To</h3>
              <div class="body-1">
                {{ earning.order_detail.addresses[1].formatted_address }}
              </div>
            </md-card-content>
          </md-card>
        </div>
        <div class="src-des">
          <md-card class="src">
            <md-card-content>
              <h3 class="md-subheading md-primary">TingsApp Profit</h3>
              <div class="body-1">Received amount: ${{ earning.order_detail.cost }}</div>
              <div class="body-1">Received gst: ${{ earning.received_gst }}</div>
              <div class="body-1">
                Payable amount: ${{ earning.carrier_earning.toFixed(3) }}
              </div>
              <div class="body-1">Paid gst: ${{ earning.paid_gst }}</div>
              <div class="body-1">Unpaid gst: ${{ earning.unpaid_gst }}</div>
              <div class="body-1">Gross profit: ${{ earning.tingsapp_earning }}</div>
              <div class="break"></div>
              <div class="body-1">
                <b
                  >Total net incom:
                  <span style="color: green"
                    >${{ earning.tingsapp_earning.toFixed(3) }}</span
                  ></b
                >
              </div>
            </md-card-content>
          </md-card>
          <md-card class="des">
            <div class="status" v-if="earning.status != 'Paid'">
              <div v-if="loading" class="loading">
                <Spinner />
              </div>
              <md-button v-else class="md-primary" @click="confirmDialog = true"
                >Pay</md-button
              >
            </div>
            <md-card-content>
              <h3 class="md-subheading md-primary">Carrier Cost Breakdown</h3>
              <div class="body-1">Travel cost: ${{ earning.travel_cost }}</div>
              <div class="body-1">Moving cost: ${{ earning.moving_cost }}</div>
              <div class="body-1">Supplies cost: ${{ earning.supplies_cost }}</div>
              <div class="body-1">Tax: ${{ earning.paid_gst }}</div>
              <div class="break"></div>
              <div class="body-1">
                <b
                  >Total payable amount:
                  <span style="color: green"
                    >${{ earning.carrier_earning.toFixed(3) }}</span
                  ></b
                >
              </div>
              <div class="body-1">Status: {{ earning.status }}</div>
            </md-card-content>
          </md-card>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Spinner from "../../shared/Spinner";
import axios from "axios";
import functions from "../../frontend/services/functions";
export default {
  name: "JobDetails",
  data: () => ({
    earning: null,
    status: ["paid", "unpaid"],
    loading: false,
    confirmDialog: false,
  }),
  methods: {
    details() {
      axios
        .get("admin/earnings/" + this.$route.params.id)
        .then((res) => {
          this.earning = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    onCancel() {},
    onConfirm() {
      this.loading = true;
      axios
        .put("admin/earnings/" + this.$route.params.id, { status: "Paid" })
        .then((res) => {
          this.details();
          this.loading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },

    formatter(date) {
      return functions.myDateFormat(date);
    },
  },
  created() {
    this.details();
  },

  components: {
    Spinner,
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: center;

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

  .earning-id {
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
.status {
  position: absolute;
  right: 0;
}
.paid {
  color: green;
}
</style>
