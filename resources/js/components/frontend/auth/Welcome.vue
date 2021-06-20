<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content">
      <md-card class="main-card">
        <md-empty-state
          md-icon="devices_other"
          md-label="Welcome to ThingsApp"
          md-description="Please complete your rgisteration."
        >
          <md-button @click="submit" class="custom-button">Complete</md-button>
        </md-empty-state>
      </md-card>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Welcome",
  components: {},
  data: () => ({
    form: {
      code: null,
      id: this.$route.params.id,
    },
    isSubmitting: false,
  }),
  created() {},
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    ...mapActions({
      signUp: "auth/signUp",
    }),
    submit() {
      if (this.user.role[0].name == "customer") {
        this.$router.push("/shipper/profile/add");
      } else if (this.user.role[0].name == "mover") {
        this.$router.push("/carrier/profile/add");
      }
    },
  },
  components: {
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.container {
  width: 100%;
  .content {
    height: calc(100vh - 3px);
    padding: 60px 30px;

    .main-card {
      width: 90%;
      min-height: 500px;
      margin: auto;
      padding: 20px;
      margin-bottom: 18px;
      text-align: center;
    }
  }
}
</style>
