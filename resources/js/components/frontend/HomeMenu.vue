<template>
  <div>
    <md-toolbar class="md-transparent" md-elevation="0"><h3>TingsApp</h3></md-toolbar>
    <md-divider></md-divider>
    <md-list>
      <md-list-item @click="navigate('/')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'home',
          }"
          >Home</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/about')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'about',
          }"
          >What is TingsApp</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/help/how-works')">
        <span class="md-list-item-text">How it works</span>
      </md-list-item>
      <md-list-item @click="navigate('/help/shipper')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'help',
          }"
          >Help center</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/cities')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'cities',
          }"
          >Cities</span
        >
      </md-list-item>
      <md-divider></md-divider>
      <md-list-item @click="navigate('/carriers')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'carriers',
          }"
          >Become a Mover</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/login')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'login',
          }"
          >My account</span
        >
      </md-list-item>
    </md-list>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  methods: {
    navigate(path) {
      this.$router.push(path);
      this.$emit("hideSideMenu");
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
};
</script>
<style lang="scss" scoped>
.md-list {
  padding-bottom: 0 !important;
  .md-list-item-text {
    font-weight: 500;
  }
}
.active {
  color: #ffa500 !important;
}
</style>
