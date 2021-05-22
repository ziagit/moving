<template>
  <div class="shipper">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <md-card>
      <md-card-header> </md-card-header>
      <md-card-content>
        <router-view></router-view>
      </md-card-content>
    </md-card>
    <Footer />
  </div>
</template>
<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
export default {
  name: "CarrierProfile",
  data: () => ({
    windowWidth: 600,
    closeOnSelect: true,
    closeOnClick: true,
  }),
  mounted() {
    window.addEventListener("resize", () => {
      this.windowWidth = window.innerWidth;
    });
  },
  methods: {
    navigateTo(route) {
      this.$router.push(route);
    },
  },
  components: {
    Footer,
    Header,
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none;
  margin: auto;
  margin-bottom: 30px !important;
  padding-bottom: 20px;
  min-height: calc(100vh - 117px);
  .md-card-header {
    text-align: right;
  }
  .md-card-content {
    padding: 0;
    text-align: center;
  }
}

@media only screen and (min-width: 600px) {
  .shipper {
    .tablet-menu {
      display: flex !important;
      text-align: left !important;
    }

    .md-card {
      margin: auto;
      margin-top: 20px;
      width: 90%;
    }
  }
}
</style>
