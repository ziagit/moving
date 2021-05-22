<template>
  <div class="shipper-payment-method">
    <md-dialog :md-active.sync="checkoutTogal">
      <md-dialog-content>
        <Card v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="zip" md-sort-order="asc" md-card>
      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()"
          >Create new address</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head></md-table-head>
        <md-table-head>Type</md-table-head>
        <md-table-head>Details</md-table-head>
        <md-table-head>Exp Date</md-table-head>
        <md-table-head>Edit</md-table-head>
      </md-table-row>
      <md-table-row v-for="(card, index) in cards" :key="index">
        <md-table-cell>
          <md-radio v-model="selected" :value="true"></md-radio>
        </md-table-cell>
        <md-table-cell>{{ card.brand }}</md-table-cell>
        <md-table-cell>************{{ card.last4 }}</md-table-cell>
        <md-table-cell>{{ card.exp_month }}/{{ card.exp_year }}</md-table-cell>
        <md-table-cell>
          <md-button @click="checkoutTogal = true" class="md-icon-button md-primary"
            ><md-icon>more_horiz</md-icon></md-button
          >
        </md-table-cell>
      </md-table-row>
    </md-table>

    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axios from "axios";
import Spinner from "../../../shared/Spinner";
import Snackbar from "../../../shared/Snackbar";
import Card from "../../card/Card";

export default {
  name: "ShipperPaymentDetails",
  components: {
    Spinner,
    Card,
    Snackbar,
  },
  data: () => ({
    selected: true,
    cards: null,
    dataLoading: true,
    order: null,
    checkoutTogal: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  created() {
    this.getCard();
  },
  methods: {
    refresh(data) {
      this.checkoutTogal = false;
      this.snackbar.show = true;
      this.snackbar.message = data.message;
      this.snackbar.statusCode = 200;
      this.getCard();
    },

    getCard() {
      axios
        .get("shipper/card-details")
        .then((res) => {
          console.log("shipper crd", res.data.data);

          if (res.data.data) {
            this.cards = res.data.data;
            this.dataLoading = false;
          } else {
            this.dataLoading = false;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none !important;
  text-align: left;
}
</style>
