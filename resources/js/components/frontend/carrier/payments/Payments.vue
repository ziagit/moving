<template>
  <md-card>
    <md-card-content>
      <div v-if="payment">
        <h1>Bank Information</h1>
        <div><span class="md-body-2">Currency:</span> {{ payment.currency }}</div>
        <div>
          <span class="md-body-2">Transit number:</span> {{ payment.transit_number }}
        </div>
        <div>
          <span class="md-body-2">Institution number:</span>
          {{ payment.institution_number }}
        </div>
        <div>
          <span class="md-body-2"> Account number:</span> {{ payment.account_number }}
        </div>
      </div>
    </md-card-content>
    <md-card-actions v-if="payment">
      <md-button :to="{ path: 'edit/' + 1 }" class="md-primary md-icon-button">
        <md-icon>edit</md-icon>
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
      <md-button to="add" class="md-icon-button md-raised">
        <md-icon>add</md-icon>
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
  box-shadow: none;
  text-align: center;

  .md-card-actions {
    display: flex;
    justify-content: space-around;
  }
}

.payment-logo {
  text-align: center;
  .md-avatar {
    box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
    min-width: 84px;
    min-height: 84px;
    color: #ffa500;
  }
}

.md-body-1 {
  width: 50%;
  margin: auto;
}
</style>
