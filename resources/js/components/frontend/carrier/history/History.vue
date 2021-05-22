<template>
  <div>
    <router-view></router-view>
  </div>
</template>
<script>
import Axios from "axios";
export default {
  name: "History",
  data: () => ({
    active: false,
    hasHistory: false
  })
};
</script>
<style lang="scss" scoped>

</style>