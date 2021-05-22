<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="order-wrapper">
      <div class="left">
        <div v-if="progressTogal()">
          <div class="row progress-bar">
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
      <div class="right">
        <md-card>
          <GoogleMap ref="drawRoute" :newSize="initSize" />
          <ul class="selected" id="ul_o" v-if="selected">
            <li v-if="selected.from">
              <div class="row">
                <md-icon>place</md-icon>
                <div class="col">
                  <span>Pickup</span><br />
                  <GoogleAddress
                    v-on:google-valid-address="originChanged"
                    :initialData="selected.from.formatted_address"
                    v-if="originTogal"
                  />
                  <span v-else> {{ selected.from.formatted_address }}</span>
                </div>
              </div>
              <md-button class="md-icon-button" @click="originTogal = !originTogal">
                <md-icon class="md-size-0x">edit</md-icon>
              </md-button>
            </li>

            <li v-if="selected.to">
              <div class="row">
                <md-icon>place</md-icon>
                <div class="col">
                  <span>Destination</span><br />
                  <GoogleAddress
                    v-on:google-valid-address="destinationChanged"
                    :initialData="selected.to.formatted_address"
                    v-if="destinationTogal"
                  />
                  <span v-else> {{ selected.to.formatted_address }}</span>
                </div>
              </div>
              <md-button
                class="md-icon-button"
                @click="destinationTogal = !destinationTogal"
              >
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <li v-if="selected.movingType">
              <div class="row">
                <md-icon>filter_list</md-icon>
                <div class="col">
                  <span>Moving type:</span><br />
                  <span> {{ selected.movingType.title }}</span>
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('moving-types')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <li v-if="selected.movingSize">
              <div class="row">
                <md-icon>crop</md-icon>
                <div class="col">
                  <span>Moving size:</span><br />
                  <span> {{ selected.movingSize.title }}</span>
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('moving-sizes')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>

            <li v-if="selected.items">
              <div class="row">
                <md-icon>list</md-icon>
                <div class="col">
                  <span>Items:</span><br />
                  <span class="md-body-1" v-for="item in selected.items" :key="item.id">
                    {{ item.name }}: {{ item.number }},
                  </span>
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('few-items')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>

            <li v-if="selected.numberOfMovers">
              <div class="row">
                <md-icon
                  ><span class="material-icons-outlined">
                    format_list_numbered
                  </span></md-icon
                >
                <div class="col">
                  <span>Number of selected movers:</span><br />
                  <span> {{ selected.numberOfMovers.number }} movers</span>
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('number-of-movers')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <li v-if="selected.vehicle">
              <div class="row">
                <md-icon
                  ><span class="material-icons-outlined">
                    emoji_transportation
                  </span></md-icon
                >
                <div class="col">
                  <span>Selected vehicle:</span><br />
                  <span> {{ selected.vehicle.name }}</span>
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('vehicle-sizes')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <li v-if="selected.date">
              <div class="row">
                <md-icon
                  ><span class="material-icons-outlined"> event_available </span></md-icon
                >
                <div class="col">
                  <span>Pickup date & time:</span><br />
                  <span>
                    {{
                      selected.date.date.year +
                      "-" +
                      selected.date.date.month +
                      "-" +
                      selected.date.date.date
                    }},
                    {{ buildTime(selected.date.time ? selected.date.time.from : "") }}
                    -
                    {{ buildTime(selected.date.time ? selected.date.time.to : "") }}</span
                  >
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('moving-date')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <li
              v-if="
                (selected.floors && selected.floors.pickup != null) ||
                (selected.floors && selected.floors.destination != null)
              "
            >
              <div class="row">
                <md-icon>location_city</md-icon>
                <div class="col">
                  <span>Floors:</span><br />
                  <span
                    >At pickup:
                    {{ selected.floors.pickup ? selected.floors.pickup : "None" }},
                  </span>
                  <span
                    >At destination:
                    {{
                      selected.floors.destination ? selected.floors.destination : "None"
                    }}</span
                  >
                </div>
              </div>
              <md-button class="md-icon-button" @click="edit('floors')">
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <li v-if="selected.supplies">
              <div class="row" v-if="selected.supplies.length > 0">
                <md-icon>takeout_dining</md-icon>
                <div class="col">
                  <span>Selected supplies:</span><br />
                  <span
                    class="md-body-1"
                    v-for="supply in selected.supplies"
                    :key="supply.id"
                  >
                    {{ supply.name }}: {{ supply.number }}
                  </span>
                </div>
              </div>
              <md-button
                v-if="selected.supplies.length > 0"
                class="md-icon-button"
                @click="edit('moving-supplies')"
              >
                <md-icon>edit</md-icon>
              </md-button>
            </li>
            <md-divider></md-divider>
            <li class="footer" v-if="selected.carrier">
              <div class="md-title">Total Price: ${{ selected.carrier.price }}</div>
            </li>
          </ul>
        </md-card>
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
import functions from "../services/functions";
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
    selected: {},
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
      this.listSize();
      this.completedSteps = prgValue;
      this.percentage = Math.floor((prgValue * 100) / this.totalSteps);
      this.init();
    },
    async originChanged(address, latlng) {
      this.$refs.drawRoute.setOrigin(address, latlng);
      localData.save("from", address);
      await this.init();
      this.originTogal = false;
      if (this.$route.path == "/order/movers") {
        this.$refs.refreshPrice.rebuild();
      }
    },
    async destinationChanged(address, latlng) {
      this.$refs.drawRoute.setDestination(address, latlng);
      localData.save("to", address);
      await this.init();
      this.destinationTogal = false;
      if (this.$route.path == "/order/movers") {
        this.$refs.refreshPrice.rebuild();
      }
    },

    init() {
      this.selected["from"] = localData.read("from");
      this.selected["to"] = localData.read("to");
      this.selected["distance"] = localData.read("distance");
      this.selected["duration"] = localData.read("duration");
      this.selected["movingType"] = localData.read("moving-type");
      this.selected["movingSize"] = localData.read("moving-size");
      this.selected["vehicle"] = localData.read("vehicle");
      this.selected["carrier"] = localData.read("carrier");
      this.selected["numberOfMovers"] = localData.read("number-of-movers");
      this.selected["date"] = localData.read("moving-date");
      this.selected["floors"] = localData.read("floors");
      this.selected["items"] = localData.read("moving-items");
      this.selected["supplies"] = functions.buildSupplies();
      console.log("selected: ", this.selected);
    },
    edit(path) {
      this.$router.push(path);
    },
    progressTogal() {
      if (
        this.$router.currentRoute.path == "/order/movers" ||
        this.$router.currentRoute.path == "/order/moving-payment" ||
        this.$router.currentRoute.path == "/order/card-details"
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
      return functions.getTimeRanges(time);
    },
  },
};
</script>

<style lang="scss" scoped>
.edit-origin {
  min-width: 300px;
}
.container {
  .order-wrapper {
    max-width: 1000px;
    margin: auto;

    min-height: calc(100vh - 15px);
    display: flex;
    justify-content: space-evenly;
    .left {
      width: 55%;
      padding: 30px;
      .progress-bar {
        display: flex;
        justify-content: center;
        align-items: center;
      }
    }
    .right {
      margin-top: 30px;
      width: 45%;
      ul {
        padding: 10px;
        min-height: 132px;
        overflow: auto;
        li {
          display: flex;
          justify-content: space-between;
          .row {
            display: flex;

            .col {
              padding-left: 10px;
              padding-bottom: 10px;
              :first-child {
                color: #ffa500;
                font-size: 12px;
              }
            }
          }
          .md-icon {
            color: #ffa500;
          }
          .md-button:hover {
            background: #ffa60062;
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
