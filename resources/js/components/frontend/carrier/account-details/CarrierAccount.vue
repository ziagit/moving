<template>
  <div class="account">
    <b-card v-if="account" header="Logo" class="border-0 shadow">
      <div class="mb-3">
        <img :src="'/images/pub/' + account.avatar" width="80" alt="" />
      </div>
      <b-button @click="edit()" variant="primary"> Change </b-button>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
export default {
  name: "CarrierAccount",
  data: () => ({
    account: null,
  }),
  methods: {
    get() {
      axios
        .get("carrier/account")
        .then((res) => {
          this.account = res.data;
          console.log("carrier acoutn: ", this.account);
        })
        .catch((err) => console.log(err));
    },
    edit() {
      this.$router.push("edit/" + this.account.id);
    },
  },
  created() {
    this.get();
  },
};
</script>
<style lang="scss" scoped>
.account {
  text-align: left;
}
</style>
