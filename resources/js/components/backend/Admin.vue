<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="admin">
      <router-view></router-view>
    </div>
    <Footer />
  </div>
</template>

<script>
import Footer from "../shared/Footer";
import Header from "../shared/Header";
export default {
  name: "Admin",
  components: {
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.admin {
  min-height: calc(100vh - 50px);
}
@media only screen and (min-width: 600px) {
  .admin {
    padding: 20px;
  }
}
</style>
