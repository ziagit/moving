<template>
  <div class="dashboard">
    <chart />
  </div>
</template>
<script>
import chart from "./dashboard/LineChart";
export default {
  name: "Dashboard",
  data: () => ({}),
  components: {
    chart,
  },
};
</script>

<style lang="scss" scoped>
.app {
  height: 100%;
  min-height: 100%;
}
</style>
