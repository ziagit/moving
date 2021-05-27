<template>
  <div class="container">
    <div v-if="checkingCard">
      <Spinner />
      <div>Checking billing info...</div>
    </div>
    <div v-else>
      <div v-if="isCardAdded" class="billing">
        <span class="md-display-1">Billing Information</span>
        <div class="break"></div>
        <div class="break"></div>
        <md-card>
          <md-card-content>
            <div
              v-if="
                authenticated && user.role[0].name === 'customer' && user.phone != null
              "
            >
              <p>Your billing information is already added</p>
              <md-button class="md-primary" @click="isCardAdded = false"
                >Do you want to use a new card?</md-button
              >
            </div>
          </md-card-content>
        </md-card>

        <div class="break"></div>
        <div class="break"></div>
        <div class="action">
          <md-button @click="next()" class="custom-button">Continue</md-button>
        </div>
      </div>
      <Card v-else />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Spinner from "../../shared/Spinner";
import localData from "../services/localData";
import Card from "../card/Card";
export default {
  name: "MovingPayment",
  components: {
    Spinner,
    Card,
  },
  data: () => ({
    checkingCard: false,
    isCardAdded: false,
    shipper: null,
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
.container {
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
