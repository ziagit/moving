<template>
  <b-card header="Bank Information" class="border-0 shadow text-left">
    <b-tabs>
      <b-tab title="Payement method">
        <div v-if="bank" class="px-3">
          <div class="row">
            <span class="col-4">Currency:</span>
            <span class="col-6">{{ bank.currency }}</span>
          </div>
          <div class="row">
            <span class="col-4">Transit number:</span>
            <span class="col-6">{{ bank.transit_number }}</span>
          </div>
          <div class="row">
            <span class="col-4">Institution number:</span>
            <span class="col-6">{{ bank.institution_number }}</span>
          </div>
          <div class="row">
            <span class="col-4">Currency:</span>
            <span class="col-6">{{ bank.account_number }}</span>
          </div>
          <div class="row">
            <span class="col-4">Account number:</span>
            <span class="col-6">{{ bank.account_number }}</span>
          </div>
          <div class="text-right mt-3" v-if="bank">
            <b-button @click="$router.push('edit/' + bank.id)" variant="primary">
              Edit
            </b-button>
          </div>
        </div>
        <div v-else>
          There is no payment method
          <b-button @click="$router.push('add')" variant="primary"> Add </b-button>
        </div>
      </b-tab>
      <b-tab title="Payment history">
        <table class="table text-left">
          <thead>
            <tr>
              <th>ID</th>
              <th>From</th>
              <th>To</th>
              <th>Amount</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(payment, index) in payments" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ payment.from }}</td>
              <td>{{ payment.to }}</td>
              <td>${{ payment.amount }}</td>
              <td>{{ payment.created_at }}</td>
            </tr>
          </tbody>
        </table>
      </b-tab>
    </b-tabs>
  </b-card>
</template>

<script>
import axios from "axios";
export default {
  name: "paymentDetails",
  data: () => ({
    payments: null,
    bank: null,
    hasCompany: false,
  }),
  methods: {
    async get() {
      await axios
        .get("carrier/bank-info")
        .then((res) => {
          this.bank = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    async getPayments() {
      await axios
        .get("carrier/payments")
        .then((res) => {
          this.payments = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },

  created() {
    this.get();
    this.getPayments();
  },
};
</script>

<style lang="scss" scoped></style>
