<template>
  <div class="select-carrier">
    <div v-show="dataLoading" class="loading">
      <Spinner />
      <span class="md-display-1">Calculating...</span>
      <div class="md-display-body">Your price will here soon. please wait</div>
    </div>

    <div v-show="!dataLoading">
      <md-card v-if="carrier != null" class="price-container">
        <div class="price">
          <span v-if="carrier.price">Your Price: ${{ carrier.price.toFixed(2) }}</span>
          <md-menu md-direction="top-start" :md-active.sync="priceToggle">
            <md-icon md-menu-trigger class="md-seconday info">info</md-icon>
            <md-menu-content>
              <CarrierRateInfo :price="carrier" />
            </md-menu-content>
          </md-menu>
        </div>
        <p>
          <span>Damage protection included.</span> <br />
          <!--       <md-menu md-direction="top-start" :md-active.sync="infoTogal">
            <span>Damage protection included.</span> <br />
            <span class="privacy" md-menu-trigger>Read</span> our protection policy.
            <md-menu-content>
              <CarrierInfo
                :lastName="carriers.name"
                :company="carriers.company"
                :detail="carriers.detail"
              />
            </md-menu-content>
          </md-menu> -->
        </p>
      </md-card>
      <div class="break"></div>
      <div class="break"></div>
      <md-card>
        <md-field>
          <label>Add a note (optional)</label>
          <md-textarea v-model="instructions"></md-textarea>
        </md-field>
      </md-card>
      <div class="break"></div>
      <div class="break"></div>
      <div class="next">
        <md-button @click="next()" class="custom-button">Place order</md-button>
      </div>
    </div>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import CarrierRateInfo from "./menu/CarrierRateInfo";
import CarrierInfo from "./menu/CarrierInfo";
import { mapActions, mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import Snackbar from "../../shared/Snackbar";
import builder from "../services/builder";
import localData from "../services/localData";
export default {
  name: "Movers",
  components: {
    CarrierRateInfo,
    CarrierInfo,
    Spinner,
    Snackbar,
  },
  data: () => ({
    carrier: null,
    order: {},
    instructions: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
    dataLoading: true,
    loginTogal: false,
    priceToggle: false,
    infoTogal: false,
  }),
  watch: {
    carrier(data) {
      for (let i = 0; i < data.length; i++) {
        data[i]["togal"] = false;
      }
    },
  },
  created() {
    this.getCarrier();
    localData.save("cr", this.$router.currentRoute.path);
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    async rebuild() {
      await this.getCarrier();
      this.$emit("price-refreshed");
    },
    async getCarrier() {
      var order = await builder.buildOrder();
      axios
        .post("carriers-rate", order)
        .then((res) => {
          console.log("mover availabe", res.data);
          if (res.data.length === 0) {
            this.dataLoading = false;
            return;
          }
          this.carrier = res.data;
          this.dataLoading = false;
        })
        .catch((err) => {
          this.dataLoading = false;
          this.snackbar.show = true;
          this.snackbar.message = err.response.data.message;
          this.snackbar.statusCode = err.response.status;
        });
    },

    next() {
      localData.save("carrier", this.carrier);
      localData.save("instructions", this.instructions);
      this.$emit("progress", 0);
      if (this.authenticated && this.user.role[0].name === "customer") {
        this.$router.push("/order/moving-payment");
      } else {
        this.$router.push("/order/contact");
        /*         this.$router.push({
          name: "signin",
          query: {
            redirect: "/order/moving-payment",
          },
        }); */
      }
    },
    refresh() {
      this.loginTogal = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.select-carrier {
  text-align: center;
  .md-card {
    text-align: left;
    min-width: 400px;
    padding: 20px;
    .price {
      display: flex;
      align-items: center;
      span {
        margin-right: 6px;
        font-size: 22px;
        font-weight: 600;
      }
    }
    .md-button {
      margin-right: 0;
      padding: 5px;
      border-radius: 5px;
    }
    .privacy {
      color: #448aff;
      cursor: pointer;
    }
    .md-has-textarea {
      margin: 0;
    }
  }
  .next {
    text-align: right;
    margin-right: 16px;
    min-width: 416px;
  }
}
.price-container {
  height: 201px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

@media only screen and (max-width: 600px) {
  .select-carrier {
    text-align: center;
    .md-card {
      min-width: 300px !important;
      margin: auto;
    }
    .next {
      min-width: 300px !important;
    }
  }
}
</style>
