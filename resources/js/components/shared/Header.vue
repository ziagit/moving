<template>
  <div>
    <b-navbar variant="faded" type="light">
      <b-button class="position-fixed menu" variant="light" @click="$emit('togal-menu')">
        <b-icon icon="list"></b-icon>
      </b-button>
      <div class="tab"></div>
      <div class="tab"></div>
      <b-navbar-brand class="ml-4" @click="$router.push('/')">
        <span>TingsApp</span>
      </b-navbar-brand>
    </b-navbar>
  </div>
</template>

<script>
export default {
  name: "Headder",
  data: () => ({
    isScrolled: false,
  }),
  watch: {
    scrollValue(value) {
      if (value > 50) {
        this.isScrolled = true;
      } else {
        this.isScrolled = false;
      }
    },
  },
  methods: {},
  created() {},
};
</script>

<style lang="scss" scoped>
span:hover {
  cursor: pointer;
}
.menu {
  z-index: 90;
}
@media only screen and (max-width: 1400px) {
}
</style>
