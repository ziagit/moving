<template>
  <div class="help">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/help.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="">Help Center</div>
        <h1>{{ header }}</h1>
        <div>
          <div>{{ subheader }}</div>
          <b-button
            class="custom-button"
            @click="$router.push('/register')"
            v-if="carrierToggal"
            >Signup now</b-button
          >
          <b-button
            class="custom-button"
            @click="$router.push('/order')"
            v-if="shipperToggal"
            >Start new quote</b-button
          >
        </div>
      </div>
    </div>

    <div class="section1">
      <b-tabs :md-active-tab="tabId">
        <b-tab
          id="shipper"
          title="Customer"
          @click="
            passData(
              (header = 'Customer'),
              (subheader = 'Top common questions about our customers')
            )
          "
        >
          <p>Not available!</p>
          <!--  <ShipperFaq /> -->
        </b-tab>
        <b-tab
          id="mover"
          title="Mover"
          @click="
            passData(
              (header = 'Mover'),
              (subheader = 'Most common questoins about our movers')
            )
          "
        >
          <p>Not available!</p>
          <!-- <CarrierFaq /> -->
        </b-tab>
      </b-tabs>
    </div>

    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import CarrierFaq from "./CarrierFaq";
import ShipperFaq from "./ShipperFaq";
export default {
  name: "ContactUs",
  data: () => ({
    form: {
      name: null,
      email: null,
      message: null,
    },
    tabId: "customer",
    header: "Customer",
    subheader: "Beginnerٌs guide to moving with TingsApp",
    carrierToggal: false,
    shipperToggal: false,
  }),
  created() {
    this.tabId = this.$route.params.id;
  },
  methods: {
    passData(header, subheader) {
      this.header = header;
      this.subheader = subheader;
      this.carrierToggal = header == "Partner" ? true : false;
      this.shipperToggal = header == "Shipper" ? true : false;
    },
  },
  components: {
    Footer,
    Header,
    CarrierFaq,
    ShipperFaq,
  },
};
</script>
<style lang="scss" scoped>
.help {
  background: #fff;

  .section0 {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    align-items: center;
    border-bottom: #ddd 1px solid;
    .content {
      height: 268px;
      padding: 85px 200px 85px 106px;

      .md-subheading {
        color: #000;
      }

      .md-button {
        margin-top: 16px;
      }
    }
  }

  .section1 {
    max-width: 1200px;
    min-height: calc(100vh - 200px);
    margin: auto;
    padding: 30px;

    .b-tabs {
      width: 100% !important;
      margin: auto;
    }
  }
}
@media only screen and (max-width: 600px) {
  .section0 {
    .content {
      padding: 20px !important;
      height: 188px !important;

      .md-subheading {
        font-size: 14px !important;
      }
    }
  }

  .section1 {
    padding: 30 !important;
  }
}
</style>
