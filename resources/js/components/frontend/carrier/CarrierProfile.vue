<template>
  <div class="carrier">
    <Header v-on:togal-menu="$emit('togal-menu')" />
    <md-card>
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
  .md-card {
    box-shadow: none;
    max-width: 1000px;
    margin: 30px auto;
    min-height: calc(100vh - 117px);
    .md-card-content {
      padding: 0;
      text-align: center;
    }
  }
}

@media only screen and (min-width: 650px) {
}
</style>
