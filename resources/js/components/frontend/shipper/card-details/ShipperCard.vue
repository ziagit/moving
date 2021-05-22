<template>
  <div class="shipper-card">
    <md-card class="no-shadow-bordered">
      <md-card-content>
        <div>
          <md-tabs>
            <md-tab id="tab-home" md-label="Payment method">
              <Methods />
            </md-tab>
            <md-tab id="tab-pages" md-label="Payment history">
              <History />
            </md-tab>
          </md-tabs>
        </div>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import History from "./History";
import Methods from "./Methods";
export default {
  name: "ShipperPaymentDetails",
  components: {
    History,
    Methods,
  },
  data: () => ({}),
  created() {},
  methods: {},
};
</script>

<style lang="scss" scoped>
.md-card {
  .md-card-content {
    text-align: center !important;
    table {
      width: 100%;
    }
  }

  .process-order {
    margin-top: 30px;
  }

  .alert-success {
    padding: 20px;
    background-color: #008000a8;
    color: white;
    border-radius: 5px;
  }

  .payment-card:hover {
    cursor: pointer;
  }
}
</style>
