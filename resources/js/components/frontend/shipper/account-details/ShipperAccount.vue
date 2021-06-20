<template>
  <b-card v-if="account" header="Avatar" class="border-0 shadow text-left">
    <div>
      <img :src="'/images/pub/' + account.avatar" width="80" alt="" />
    </div>
    <div class="mt-3">
      <b-button @click="change()" variant="primary"> Change </b-button>
    </div>
  </b-card>
</template>
<script>
import axios from "axios";
export default {
  name: "ShipperAccount",
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
    change() {
      this.$router.push("edit/" + this.account.id);
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
