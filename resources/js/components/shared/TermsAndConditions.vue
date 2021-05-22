<template>
  <div class="info">
    <div class="content">
      <div class="md-body-2">TingsApp Terms & Conditions</div>
    </div>
    <ul>
      <li>
        any user of the services that arranges to have goods moved. Mover may be referred
        to as the “Customer”.
      </li>
      <li><router-link to="/terms-and-conditions">Read more</router-link></li>
    </ul>
  </div>
</template>
<script>
export default {
  name: "TermsAndConditions",
  props: ["detail", "name"],
};
</script>
<style lang="scss" scoped>
.info {
  min-width: 100%;
  min-height: 100%;
  .content {
    padding: 20px 20px 0 20px;
    ul {
      padding: 0;
      li {
        list-style-type: none;
      }
    }
  }
}
</style>
