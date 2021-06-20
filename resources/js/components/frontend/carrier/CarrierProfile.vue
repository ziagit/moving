<template>
  <div class="carrier">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="container mb-5 mt-5">
      <router-view></router-view>
    </div>
    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
export default {
  name: "CarrierProfile",
  data: () => ({
    closeOnSelect: true,
    closeOnClick: true,
  }),

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
.carrier {
  .container {
    margin: 30px auto;
    min-height: calc(100vh - 117px);
  }
}

@media only screen and (min-width: 600px) {
  .carrier {
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
