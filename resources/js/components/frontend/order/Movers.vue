<template>
  <div class="select-carrier">
    <div v-show="dataLoading" class="loading">
      <b-spinner variant="primary" />
      <h1>Calculating...</h1>
      <div class="md-display-body">Your price will here soon. please wait</div>
    </div>

    <div v-show="!dataLoading">
      <b-card v-if="carrier != null" class="price-container border-0 shadow">
        <div class="price">
          <span v-if="carrier.price">Your Price: ${{ carrier.price.toFixed(2) }}</span>
          <div class="text-center my-3">
            <b-button id="popover-target-1" variant="ligth">
              <b-icon icon="info-circle-fill" aria-hidden="true"></b-icon>
            </b-button>
            <b-popover target="popover-target-1" triggers="hover" placement="top">
              <template #title>Price Breakdown</template>
              <CarrierRateInfo :price="carrier" />
            </b-popover>
          </div>
        </div>
        <p><span>Damage protection included.</span> <br /></p>
      </b-card>
      <div class="break"></div>
      <div class="break"></div>
      <b-card class="border-0 shadow">
        <b-form-textarea
          v-model="instructions"
          placeholder="Add a note (optional)"
          rows="3"
          max-rows="6"
        ></b-form-textarea>
        <div class="break"></div>
        <div class="break"></div>
        <div class="submit">
          <b-button variant="primary" @click="next()">Place order</b-button>
        </div>
      </b-card>
    </div>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import CarrierRateInfo from "./menu/CarrierRateInfo";
import CarrierInfo from "./menu/CarrierInfo";
import { mapActions, mapGetters } from "vuex";
import Toaster from "../../shared/Toaster";
import builder from "../services/builder";
import localData from "../services/localData";
export default {
  name: "Movers",
  components: {
    CarrierRateInfo,
    CarrierInfo,
    Toaster,
  },
  data: () => ({
    carrier: null,
    order: {},
    instructions: null,
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
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            err.response.data.message
          );
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
  width: 100%;
  .price-container {
    text-align: left;
    min-width: 400px;
    padding: 20px;
    height: 201px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    .price {
      display: flex;
      align-items: center;
      span {
        margin-right: 6px;
        font-size: 22px;
        font-weight: 600;
      }
    }

    .privacy {
      color: #448aff;
      cursor: pointer;
    }
    .md-has-textarea {
      margin: 0;
    }
  }
}
.submit {
  text-align: right;
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
