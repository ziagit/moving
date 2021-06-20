<template>
  <div class="container">
    <b-card class="border-0 shadow text-left">
      <b-tabs>
        <b-tab title="Payment method">
          <Methods />
        </b-tab>
        <b-tab title="Payment history">
          <History />
        </b-tab>
      </b-tabs>
    </b-card>
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

<style lang="scss" scoped></style>
