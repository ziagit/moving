<template>
  <div>
    <div class="pl-3 pt-3 pb-3"><h3 class="mb-0">TingsApp</h3></div>
    <div class="line"></div>
    <b-list-group>
      <b-list-group-item button class="border-0" @click="navigate('/')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'home',
          }"
        >
          Home
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/about')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'about',
          }"
        >
          What is TingsApp
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/how-it-works')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'how-it-works',
          }"
        >
          How it works
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/help')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'help',
          }"
        >
          Help center
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/cities')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'cities',
          }"
        >
          Cities
        </span>
      </b-list-group-item>
      <div class="line"></div>
      <b-list-group-item button class="border-0" @click="navigate('/carriers')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'carriers',
          }"
        >
          Become a Mover
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/login')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'login',
          }"
        >
          My account
        </span>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({}),
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
