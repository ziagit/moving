<template>
  <div class="shipper">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="mt-5 mb-5">
      <router-view></router-view>
    </div>
    <Footer />
  </div>
</template>
<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
export default {
  name: "ShipperProfile",
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
@media only screen and (min-width: 600px) {
}
</style>
