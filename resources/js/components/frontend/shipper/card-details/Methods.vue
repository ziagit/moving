<template>
  <div>
    <md-dialog :md-active.sync="checkoutTogal">
      <md-dialog-content>
        <Card v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>
    <table class="table" v-if="cards">
      <thead>
        <tr>
          <th colspan="2">Type</th>
          <th>Details</th>
          <th>Exp Date</th>
          <th>Edit</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(card, index) in cards" :key="index">
          <td>
            <md-radio v-model="selected" :value="true"></md-radio>
          </td>
          <td>{{ card.brand }}</td>
          <td>************{{ card.last4 }}</td>
          <td>{{ card.exp_month }}/{{ card.exp_year }}</td>
          <td>
            <b-button @click="checkoutTogal = true" variant="light"
              ><b-icon icon="pencil"></b-icon
            ></b-button>
          </td>
        </tr>
      </tbody>
    </table>
    <div v-else class="text-center px-6">
      <p>No card added yet!</p>
      <b-button @click="checkoutTogal = true" variant="primary"> Add </b-button>
    </div>
    <Toaster :data="Toaster" />
  </div>
</template>

<script>
import axios from "axios";
import Card from "../../card/Card";
import Toaster from "../../../shared/Toaster";

export default {
  name: "ShipperPaymentDetails",
  components: {
    Card,
    Toaster,
  },
  data: () => ({
    selected: true,
    cards: null,
    dataLoading: true,
    order: null,
    checkoutTogal: false,
  }),
  created() {
    this.getCard();
  },
  methods: {
    refresh(data) {
      this.checkoutTogal = false;
      this.$refs.toaster.show("success", "b-toaster-top-right", "Success", data.message);
      this.getCard();
    },
    getCard() {
      axios
        .get("shipper/card-details")
        .then((res) => {
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

<style lang="scss" scoped></style>
