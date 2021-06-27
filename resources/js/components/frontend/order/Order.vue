<template>
  <div class="order">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="order-wrapper row mb-5">
      <div class="left col-7">
        <div v-if="progressTogal()">
          <div class="progress">
            <radial-progress-bar
              :diameter="120"
              :completed-steps="completedSteps"
              :total-steps="totalSteps"
              innerStrokeColor="#F0F2F5"
              startColor="#f97d4a"
              stopColor="#ffa500"
            >
              <p style="font-weight: bold">{{ percentage }}%</p>
            </radial-progress-bar>
          </div>
          <div class="break"></div>
          <div class="break"></div>
        </div>

        <div class="row inputs">
          <router-view
            v-on:progress="progress"
            v-on:destinationChanged="destinationChanged"
            v-on:originChanged="originChanged"
            ref="refreshPrice"
          ></router-view>
        </div>
      </div>
      <div class="right col-5">
        <b-card class="border-0 shadow">
          <GoogleMap
            ref="drawRoute"
            :newSize="initSize"
            v-on:refresh-price="refreshPrice"
          />
          <ul class="selectedData" id="ul_o" v-if="selectedData">
            <li v-if="selectedData.from">
              <div class="row" style="width: 95%">
                <b-icon icon="geo" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Pickup</span><br />
                  <GoogleAddress
                    v-on:google-valid-address="originChanged"
                    :initialData="selectedData.from.formatted_address"
                    v-if="originTogal"
                  />
                  <span v-else class="lst">
                    {{ selectedData.from.formatted_address }}</span
                  >
                </div>
              </div>
              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="originTogal = !originTogal"
              ></b-icon>
            </li>

            <li v-if="selectedData.to">
              <div class="row" style="width: 95%">
                <b-icon icon="geo" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Destination</span><br />
                  <GoogleAddress
                    v-on:google-valid-address="destinationChanged"
                    :initialData="selectedData.to.formatted_address"
                    v-if="destinationTogal"
                  />
                  <span v-else class="lst"> {{ selectedData.to.formatted_address }}</span>
                </div>
              </div>

              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="destinationTogal = !destinationTogal"
              ></b-icon>
            </li>
            <li v-if="selectedData.movingType">
              <div class="row">
                <b-icon icon="filter" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Moving type:</span><br />
                  <span class="lst"> {{ selectedData.movingType.title }}</span>
                </div>
              </div>

              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('moving-types')"
              ></b-icon>
            </li>
            <li v-if="selectedData.movingSize">
              <div class="row">
                <b-icon icon="aspect-ratio" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Moving size:</span><br />
                  <span class="lst"> {{ selectedData.movingSize.title }}</span>
                </div>
              </div>

              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('moving-sizes')"
              ></b-icon>
            </li>
            <li v-if="selectedData.items">
              <div class="row">
                <b-icon icon="card-list" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Items:</span><br />
                  <span class="lst" v-for="item in selectedData.items" :key="item.id">
                    {{ item.name }}: {{ item.number }},
                  </span>
                </div>
              </div>

              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('few-items')"
              ></b-icon>
            </li>
            <li v-if="selectedData.numberOfMovers">
              <div class="row">
                <b-icon
                  icon="sort-numeric-up"
                  font-scale="1.5"
                  variant="warning"
                ></b-icon>
                <div class="col">
                  <span>Movers:</span><br />
                  <span class="lst">
                    {{ selectedData.numberOfMovers.number }} movers</span
                  >
                </div>
              </div>
              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('number-of-movers')"
              ></b-icon>
            </li>
            <li v-if="selectedData.vehicle">
              <div class="row">
                <b-icon icon="truck-flatbed" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Vehicle:</span><br />
                  <span class="lst"> {{ selectedData.vehicle.name }}</span>
                </div>
              </div>
              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('vehicle-sizes')"
              ></b-icon>
            </li>
            <li v-if="selectedData.date">
              <div class="row">
                <b-icon
                  icon="calendar2-check"
                  font-scale="1.5"
                  variant="warning"
                ></b-icon>
                <div class="col">
                  <span>Pickup date & time:</span><br />
                  <span class="lst">
                    {{
                      selectedData.date.date.year +
                      "-" +
                      selectedData.date.date.month +
                      "-" +
                      selectedData.date.date.date
                    }},
                    {{ buildTime(selectedData.date.time.from) }}
                    -
                    {{ buildTime(selectedData.date.time.to) }}</span
                  >
                </div>
              </div>

              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('moving-date')"
              ></b-icon>
            </li>
            <li
              v-if="
                (selectedData.floors && selectedData.floors.pickup != null) ||
                (selectedData.floors && selectedData.floors.destination != null)
              "
            >
              <div class="row">
                <b-icon
                  icon="bar-chart-steps"
                  font-scale="1.5"
                  variant="warning"
                ></b-icon>
                <div class="col">
                  <span>Floors:</span><br />
                  <span class="lst"
                    >At pickup:
                    {{
                      selectedData.floors.pickup ? selectedData.floors.pickup : "None"
                    }},
                  </span>
                  <span class="lst"
                    >At destination:
                    {{
                      selectedData.floors.destination
                        ? selectedData.floors.destination
                        : "None"
                    }}</span
                  >
                </div>
              </div>
              <b-icon
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('floors')"
              ></b-icon>
            </li>
            <li v-if="selectedData.supplies">
              <div class="row" v-if="selectedData.supplies.length > 0">
                <b-icon icon="box-seam" font-scale="1.5" variant="warning"></b-icon>
                <div class="col">
                  <span>Supplies:</span><br />
                  <span
                    class="lst"
                    v-for="supply in selectedData.supplies"
                    :key="supply.id"
                  >
                    {{ supply.name }}: {{ supply.number }}
                  </span>
                </div>
              </div>

              <b-icon
                v-if="selectedData.supplies.length > 0"
                icon="pencil-square"
                font-scale="1.2"
                class="edit"
                @click="edit('moving-supplies')"
              ></b-icon>
            </li>
            <hr v-if="togal()" />
            <li v-if="togal()">
              <div class="footer">
                <h5>Price: ${{ selectedData.carrier.price }}</h5>
              </div>
            </li>
          </ul>
        </b-card>
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import RadialProgressBar from "vue-radial-progress";
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import GoogleMap from "../../shared/GoogleMap";
import localData from "../services/localData";
import builder from "../services/builder";
import GoogleAddress from "../../shared/GoogleAddress.vue";
export default {
  name: "Order",
  components: {
    RadialProgressBar,
    Header,
    Footer,
    GoogleMap,
    GoogleAddress,
  },
  data: () => ({
    completedSteps: 0,
    totalSteps: 6,
    percentage: 0,
    selectedData: {},
    initSize: null,
    destinationTogal: false,
    originTogal: false,
  }),
  created() {
    this.init();
  },
  mounted() {
    this.listSize();
  },
  methods: {
    progress(prgValue) {
      console.log("yyyyyy", prgValue);
      this.init();
      this.listSize();
      this.completedSteps = prgValue;
      this.percentage = Math.floor((prgValue * 100) / this.totalSteps);
    },
    async originChanged(address, latlng) {
      this.$refs.drawRoute.setOrigin(address, latlng);
      localData.save("from", address);
      await this.init();
      this.originTogal = false;
    },
    async destinationChanged(address, latlng) {
      this.$refs.drawRoute.setDestination(address, latlng);
      localData.save("to", address);
      await this.init();
      this.destinationTogal = false;
    },
    init() {
      this.selectedData["from"] = localData.read("from");
      this.selectedData["to"] = localData.read("to");
      this.selectedData["distance"] = localData.read("distance");
      this.selectedData["duration"] = localData.read("duration");
      this.selectedData["movingType"] = localData.read("moving-type");
      this.selectedData["movingSize"] = localData.read("moving-size");
      this.selectedData["vehicle"] = localData.read("vehicle");
      this.selectedData["numberOfMovers"] = localData.read("number-of-movers");
      this.selectedData["date"] = localData.read("moving-date");
      this.selectedData["floors"] = localData.read("floors");
      this.selectedData["items"] = localData.read("moving-items");
      this.selectedData["supplies"] = builder.buildSupplies();
      this.selectedData["carrier"] = localData.read("carrier");
      console.log("selectedData ", this.selectedData);
    },
    progressTogal() {
      if (
        this.$router.currentRoute.path == "/order/movers" ||
        this.$router.currentRoute.path == "/order/moving-payment" ||
        this.$router.currentRoute.path == "/order/card-details" ||
        this.$router.currentRoute.path == "/order/contact" ||
        this.$router.currentRoute.path == "/order/verify"
      ) {
        return false;
      } else {
        return true;
      }
    },
    listSize() {
      var size = document.getElementById("ul_o").getElementsByTagName("li").length;
      setTimeout(() => {
        if (size <= 3) {
          this.initSize = "444px";
        } else if (size > 3 && size < 6) {
          this.initSize = "300px";
        } else {
          this.initSize = " 200px";
        }
      }, 1000);
    },
    buildTime(time) {
      return time < 10 ? "0" + time + ":00" : time + ":00";
    },
    edit(path) {
      this.$router.push(path);
    },
    togal() {
      if (this.selectedData.carrier) {
        if (this.$route.path != "/order/movers") {
          return true;
        }
      }
    },
    refreshPrice() {
      if (this.$route.path == "/order/movers") {
        this.$refs.refreshPrice.rebuild();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.edit-origin {
  min-width: 300px;
}
.order {
  .order-wrapper {
    max-width: 1000px;
    margin: auto;

    min-height: calc(100vh - 15px);
    display: flex;
    justify-content: space-evenly;
    .left {
      padding: 30px;
    }
    .right {
      margin-top: 30px;
      ul {
        padding: 10px;
        margin: 0;
        min-height: 132px;
        overflow: auto;
        li {
          display: flex;
          justify-content: space-between;
          align-items: center;
          .row {
            margin-left: 0px;
            display: flex;
            align-items: center;
            .col {
              padding-left: 10px;
              :first-child {
                color: #ffa500;
                font-size: 12px;
              }
              .lst {
                font-size: 14px;
              }
            }
          }
          .edit:hover {
            cursor: pointer;
            color: #ffa500;
          }
        }
        .footer {
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 50px;
          width: 100%;
          bottom: 0;
          .md-title {
            text-align: center;
          }
        }
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .order-wrapper {
    width: 100%;
    .left {
      width: 100% !important;
    }
    .right {
      display: none;
    }
  }
  .md-display-1 {
  }
}
</style>
