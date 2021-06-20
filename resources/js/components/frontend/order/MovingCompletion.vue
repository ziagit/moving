<template>
  <div class="container completion">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <div class="content mt-5">
      <b-card class="border-0 shadow px-0">
        <b-alert show variant="success" class="mb-0">
          <h4 class="alert-heading">Well done!</h4>
          <p>Your order is placed with us;</p>
          <p>Your confirmation number is: {{ $route.params.id }}</p>
          <hr />
          <p class="mb-0">
            <b-button variant="outline-success" @click="$router.push('/')"
              >Back to home</b-button
            >
          </p>
        </b-alert>
      </b-card>
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
