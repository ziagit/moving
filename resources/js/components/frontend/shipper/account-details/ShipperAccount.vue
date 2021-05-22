<template>
  <div class="shipper-account">
    <md-card class="no-shadow-bordered">
      <md-card-header>
        <div class="md-title">Shipper account details</div>
      </md-card-header>
      <md-card-content>
        <div v-if="account">
          <div class="md-subheading">{{ account.name }}</div>
          <div class="md-subheading">{{ account.email }}</div>
        </div>

        <md-empty-state
          v-else
          class="md-primary"
          md-icon="sentiment_satisfied_alt"
          md-label="Not available"
          md-description="Account details not available"
        ></md-empty-state>
      </md-card-content>
      <md-card-actions>
        <md-button
          v-if="account"
          :to="{ path: 'edit/' + account.id }"
          class="md-primary md-icon-button"
        >
          <md-icon>edit</md-icon>
          <md-tooltip>Edit profile</md-tooltip>
        </md-button>
      </md-card-actions>
    </md-card>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "ShipperAccountDetails",
  data: () => ({
    account: null,
  }),
  methods: {
    shipperAccount() {
      axios
        .get("shipper/account")
        .then((res) => {
          this.account = res.data;
          console.log("shipper acoutn: ", this.account);
        })
        .catch((err) => console.log(err));
    },
  },
  created() {
    this.shipperAccount();
  },
};
</script>
<style lang="scss" scoped>
.shipper-account {
  .md-card {
    text-align: center;
    .md-display-1 {
      font-size: 30px;
    }
    .md-card-actions {
      display: flex;
      justify-content: space-around;
    }
  }
}
</style>
