<template>
  <div></div>
</template>
<script>
export default {
  name: "Toaster",
  methods: {
    show(variant, position = null, title, message) {
      this.$bvToast.toast(`${message}`, {
        title: title,
        variant: variant,
        toaster: position,
        solid: true,
      });
    },
  },
};
</script>
