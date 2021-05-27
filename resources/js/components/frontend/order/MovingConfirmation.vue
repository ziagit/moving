<template>
  <div class="confirmation">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <!-- <div class="content">
      <div class="header">
        <div class="md-display-1">Confirmation</div>
        <div class="md-body-1">
          Please take a look at the details to confirm the moving.
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <md-card v-if="shipment">
        <md-card-content>
          <div>
            <div class="item-head md-primary"><b>From</b></div>
            <div class="item">
              <div class="md-body-1">Address: {{ shipment.from.formatted_address }}</div>

              <div class="md-body-1" v-if="shipment.floors">
                Floor:
                {{ shipment.floors.pickup ? shipment.floors.pickup : "No stairs" }}
              </div>
            </div>
          </div>
          <div>
            <div class="item-head md-primary"><b>To</b></div>
            <div class="item">
              <div class="md-body-1">Address: {{ shipment.to.formatted_address }}</div>
              <div class="md-body-1" v-if="shipment.floors">
                Floor:
                {{
                  shipment.floors.destination ? shipment.floors.destination : "No stairs"
                }}
              </div>
            </div>
          </div>
          <div>
            <div class="item-head md-primary"><b>Contact Information</b></div>
            <div class="item">
              <div class="md-body-1">Name: {{ shipment.contacts.name }}</div>
              <div class="md-body-1">Phone: {{ shipment.contacts.phone }}</div>
              <div class="md-body-1">Email: {{ shipment.contacts.email }}</div>
            </div>
          </div>
          <div v-if="shipment.supplies && shipment.supplies.length > 0">
            <div class="item-head md-primary"><b>Selected Supplies</b></div>
            <div class="item">
              <div class="md-body-1" v-for="supply in shipment.supplies" :key="supply.id">
                <div class="md-body-1">{{ supply.name }}: {{ supply.number }}</div>
              </div>
            </div>
          </div>

          <div>
            <div class="item-head md-primary"><b>Selected Mover</b></div>
            <div class="item">
              <div class="md-body-1">
                Name:
                {{ shipment.carrier.company }}
              </div>
              <div class="md-body-1" v-if="shipment.vehicle">
                Requested vehicle: {{ shipment.vehicle.name }}
              </div>
              <div class="md-body-1" v-if="shipment.number_of_movers">
                Requested movers: {{ shipment.number_of_movers.number }}
              </div>
              <div class="md-body-1">
                Cost:
                <span class="green">${{ Math.round(shipment.carrier.price) }}</span>
              </div>
            </div>
          </div>
          <div v-if="shipment.items">
            <div class="item-head md-primary"><b>Items</b></div>
            <div class="item">
              <div class="md-body-1" v-for="item in shipment.items" :key="item.name">
                <span>{{ item.name }}: {{ item.number }}</span>
              </div>
            </div>
          </div>
          <div>
            <div class="item-head md-primary"><b>Other Informations</b></div>
            <div class="item">
              <div class="md-body-1">
                Pickup date:
                {{ shipment.moving_date.date }}
              </div>
              <div class="md-body-1">
                Appointment time:
                {{ shipment.moving_date.time }}
              </div>
              <div v-if="shipment.moving_type.code == 'office'">
                <div class="md-body-1">
                  Moving size:
                  {{ shipment.moving_size.title }}
                </div>
              </div>
              <div v-else-if="shipment.moving_type.code == 'apartment'">
                <div class="md-body-1">
                  Moving size:
                  {{ shipment.moving_size.title }}
                </div>
              </div>
              <div v-else>
                Selected items:
                <span v-for="(item, index) in shipment.items" :key="index"
                  >{{ item.name }}:{{ item.number }},
                </span>
              </div>
            </div>
          </div>
          <div>
            <div class="item-head md-primary"><b>Billing Details</b></div>
            <div class="item-head">The following email is attached to your card</div>
            <div class="item">
              <div class="md-body-1">{{ shipment.billing.email }}</div>
              <div class="md-body-1">
                Status:
                <span class="green" v-if="shipment.billing.status">Paid</span>
              </div>
            </div>
          </div>

          <div>
            <p>Important Notice</p>
            <ul>
              <li>
                All rates quoted are provided according to the tocription of Goods
                declared by the Shipper and may be subject to additional charges in the
                case of misdeclaration.
              </li>
              <li>
                If your load needs Special Handling, please select it for an accurate
                quote. Carriers charge for Special Handling if needed, and this will
                affect your final invoice.
              </li>
              <li>
                The pickup date and transit time vary by the carrier and are not
                guaranteed unless otherwise stated.
              </li>
              <li>
                Here is our<a href="/terms-and-conditions">Terms & Conditions</a>
                for
              </li>
            </ul>
            <div class="confirm">
              <p>By clicking on Confirm you accept our Terms & Conditions</p>
              <div v-if="paymentStatus">
                <Spinner v-if="dataLoading" />
                <md-button v-if="!dataLoading" @click="confirm()" class="md-primary"
                  >Confirm</md-button
                >
              </div>
            </div>
          </div>
        </md-card-content>
      </md-card>
    </div> -->
    <div class="confirming">
      <div>
        <div class="md-title">Please wait !</div>
        <div>Your order is processing...</div>
        <div class="break"></div>
        <Spinner />
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import axios from "axios";
import functions from "../services/functions";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import TermsAndConditions from "../../shared/TermsAndConditions";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import localData from "../services/localData";
export default {
  name: "Confirmation",
  data: () => ({
    shipment: null,
    paymentStatus: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  methods: {
    confirm() {
      axios
        .post("confirm", this.shipment)
        .then((res) => {
          localData.removeAll();
          console.log("order completed: ", res.data);
          this.$router.push("completion/" + res.data.uniqid);
        })
        .catch((err) => {
          this.snackbar.show = true;
          this.snackbar.message = err.message;
          this.snackbar.statusCode = err.status;
          console.log("Error: ", err);
        });
    },
    async init() {
      this.shipment = await functions.buildOrder();
      this.shipment.moving_date.date = await functions.buildDate();
      this.shipment.moving_date.time = await functions.buildTime();
      console.log("shipment: ", this.shipment);
      this.confirm();
    },
  },
  created() {
    this.init();
    /*this.checkPayment(); */
  },
  components: {
    Spinner,
    Snackbar,
    TermsAndConditions,
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.confirmation {
  text-align: center;
  .content {
    max-width: 600px;
    margin: auto;
    padding: 30px;

    .md-card {
      text-align: left;
      margin: auto;
      .md-card-content {
        padding: 20px;

        .loading {
          text-align: right;
        }
      }

      .item {
        margin: 0 0 10px 10px;

        .green {
          color: green;
        }
      }
    }

    .md-body-1 {
      width: 100% !important;
    }
    .confirm {
      div {
        text-align: right;
      }
    }

    .term-link {
      color: #448aff;
    }

    .term-link:hover {
      cursor: pointer;
    }
  }
}
.confirming {
  height: calc(100vh - 50px);
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}
</style>
