<template>
  <div class="shipper-account">
    <md-card v-if="account">
      <md-card-header>
        <span class="md-title">Avatar</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div>
          <img :src="'/images/uploads/avatar.svg'" width="80" alt="" />
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button :to="{ path: 'edit/' + account.id }" class="md-primary">
          Change
          <md-tooltip>Change avatar</md-tooltip>
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
    togal: false,
    account: null,
  }),
  methods: {
    shipperAccount() {
      axios
        .get("shipper/account")
        .then((res) => {
          this.account = res.data;
          console.log("shipper acoutn: ", res.data);
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
    text-align: left;
    padding: 20px;
    .md-card-actions {
      display: flex;
      justify-content: flex-start;
    }
  }
}
</style>
