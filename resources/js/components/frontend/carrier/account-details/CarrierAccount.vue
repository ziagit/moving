<template>
  <div class="account">
    <md-card v-if="account">
      <md-card-header>
        <span class="md-title">Logo</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div>
          <img :src="'/images/pub/' + account.avatar" width="80" alt="" />
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button :to="{ path: 'edit/' + account.id }" class="md-primary">
          Change
          <md-tooltip>Change logo</md-tooltip>
        </md-button>
      </md-card-actions>
    </md-card>
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
  },
  created() {
    this.get();
  },
};
</script>
<style lang="scss" scoped>
.account {
  .md-card {
    text-align: left;
    .md-card-content {
      padding: 20px;
    }
    .md-card-actions {
      display: flex;
      justify-content: flex-start;
    }
  }
}
</style>
