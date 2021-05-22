<template>
  <div class="container">
    <span>Rate the performance of this carrier</span>
    <div>
      <md-button class="md-primary">Cancel</md-button>
      <md-button class="md-primary">Ok</md-button>
    </div>
  </div>
</template>
<script>
export default {
  name: "Rate",
  props: ["carrierId"],
  data: () => ({}),
  created() {
    console.log("c id: ", this.carrierId);
  },
};
</script>
<style scoped>
.container {
  text-align: center;
}
</style>
