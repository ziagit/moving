<template>
  <div class="container">
    <router-view></router-view>
  </div>
</template>
<script>
export default {
  name: "ShipperOrderContainer",
};
</script>
<style lang="scss" scoped>
.container {
  height: calc(100vh - 50px);
}
</style>
