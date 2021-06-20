<template>
  <div class="container">
    <router-view></router-view>
  </div>
</template>
<script>
export default {
  name: "Account",
};
</script>
<style lang="scss" scoped>
.container {
  height: calc(100vh - 50px);
}
</style>
