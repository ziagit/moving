<template>
  <div class="list-item-container">
    <div class="list-item-head p-8">
      {{ list.title }}
      <span
        class="toggle float-right"
        @click="list.visible = !list.visible"
        v-text="toggletText[list.visible * 1]"
      >
      </span>
    </div>
    <div class="list-item-body p-8" v-show="list.visible">
      <slot />
    </div>
  </div>
</template>
<script>
export default {
  props: ["list"],
  data() {
    return { toggletText: ["show", "hide"] };
  },
};
</script>
<style scoped>
.list-item-container {
  margin: 0 auto;
  margin-bottom: 10px;
}
.p-8 {
  padding: 8px;
}
.list-item-head {
  background-color: #e6edfa;
  color: #448aff;
}
.float-right {
  float: right;
}
.toggle {
  cursor: pointer;
}
</style>
