<template>
  <form @submit.prevent="update">
    <b-form-group>
      <b-form-input v-model="form.title" required placeholder="Title"></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Update</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  props: ["type"],
  data() {
    return {
      form: {
        title: this.type.title,
        code: this.type.code,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/moving-types/" + this.type.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
