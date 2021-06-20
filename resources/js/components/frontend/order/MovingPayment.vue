<template>
  <div class="origin">
    <div v-if="checkingCard">
      <b-spinner variant="primary" />
      <div>Checking billing info...</div>
    </div>
    <div v-else>
      <div v-if="isCardAdded" class="billing">
        <span class="md-display-1">Billing Information</span>
        <div class="break"></div>
        <div class="break"></div>
        <b-card class="border-0 shadow">
          <div
            v-if="authenticated && user.role[0].name === 'customer' && user.phone != null"
          >
            <p>Your billing information is already added</p>
            <b-button variant="light" @click="isCardAdded = false"
              >Do you want to use another card?</b-button
            >
          </div>
          <div class="break"></div>
          <div class="break"></div>
          <div class="action">
            <b-button @click="next()" variant="primary"> Continue </b-button>
          </div>
        </b-card>
      </div>
      <Card v-else />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Card from "../card/Card";
export default {
  name: "MovingPayment",
  components: {
    Card,
  },
  data: () => ({
    checkingCard: false,
    isCardAdded: false,
  }),
  created() {
    this.getCard();
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    getCard() {
      this.checkingCard = true;
      axios
        .get("shipper/card-details")
        .then((res) => {
          if (res.data) {
            this.isCardAdded = true;
            this.checkingCard = false;
            console.log("card exist", res.data);
          } else {
            this.checkingCard = false;
            console.log("card not exist", res.data);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },

    next() {
      this.$router.push("/confirmation");
    },
  },
};
</script>

<style lang="scss" scoped>
.origin {
  margin: auto;
  text-align: center;
  .md-card {
    margin: 0;
    text-align: left;
  }
  .action {
    text-align: right;
  }
}
</style>
