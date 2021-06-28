<template>
  <div>
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="mb-5 mt-5 container">
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
.container {
  min-height: calc(100vh - 50px) !important;
}
@media only screen and (min-width: 600px) {
}
</style>
