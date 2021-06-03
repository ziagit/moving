<template>
  <md-card>
    <md-card-header>
      <div class="md-title">Bank Information</div>
    </md-card-header>
    <md-divider></md-divider>
    <md-card-content>
      <md-tabs>
        <md-tab id="tab-home" md-label="Payement method">
          <div v-if="payment">
            <div class="row">
              <span>Currency:</span>
              <span>{{ payment.currency }}</span>
            </div>
            <div class="row">
              <span>Transit number:</span>
              <span>{{ payment.transit_number }}</span>
            </div>
            <div class="row">
              <span>Institution number:</span>
              <span>{{ payment.institution_number }}</span>
            </div>
            <div class="row">
              <span>Currency:</span>
              <span>{{ payment.account_number }}</span>
            </div>
            <div class="row">
              <span>Account number:</span>
              <span>{{ payment.account_number }}</span>
            </div>
          </div>
        </md-tab>
        <md-tab id="tab-pages" md-label="Payment history">
          do we realy need this part?, because we already have payment information in the
          earning with the dates
        </md-tab>
      </md-tabs>
    </md-card-content>
    <md-card-actions v-if="payment">
      <md-button :to="{ path: 'edit/' + 1 }" class="md-primary">
        Edit
        <md-tooltip>Edit profile</md-tooltip>
      </md-button>
    </md-card-actions>
    <md-empty-state
      v-else
      class="md-primary"
      md-icon="sentiment_satisfied_alt"
      md-label="Not available"
      md-description="Click + icon to add"
    >
      <md-button to="add" class="md-primary">
        Add
        <md-tooltip>Add </md-tooltip>
      </md-button>
    </md-empty-state>
  </md-card>
</template>

<script>
import axios from "axios";
export default {
  name: "paymentDetails",
  data: () => ({
    payment: null,
    hasCompany: false,
  }),
  methods: {
    async get() {
      await axios
        .get("carrier/payments")
        .then((res) => {
          this.payment = res.data;
          console.log("payment: ", this.payment);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },

  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .md-card-content {
    .md-card-actions {
      display: flex;
      justify-content: flex-start;
    }
    .row {
      display: flex;
      > :first-child {
        min-width: 150px;
      }
    }
  }
}
</style>
