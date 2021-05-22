<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div class="content">
      <md-card>
        <p style="font-size: 20px">Thank you!</p>
        <p>Your order is placed with us;</p>
        <p>Your confirmation number : {{ $route.params.id }}</p>
        <md-button to="/" class="md-primary">Back to home</md-button>
      </md-card>
    </div>
    <Footer />
  </div>
</template>

<script>
import Header from "../../shared/Header";
import Footer from "../../shared/Footer";
export default {
  name: "Complation",
  data: () => ({}),
  updated() {
    window.location.reload();
  },
  components: {
    Header,
    Footer,
  },
};
</script>

<style lang="scss" scoped>
.header {
  .right {
    background: red !important;
    padding-right: 20px !important;
  }
}
.content {
  max-width: 600px;
  min-height: calc(100vh - 96px);
  margin: auto;

  .md-card {
    padding: 20px;
    text-align: center;
  }
}
</style>
