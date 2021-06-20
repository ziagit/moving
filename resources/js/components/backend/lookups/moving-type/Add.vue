<template>
  <form @submit.prevent="save">
    <b-form-group class="">
      <b-form-input v-model="form.title" required placeholder="Title"></b-form-input>
    </b-form-group>
    <b-form-group class="">
      <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Save</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      form: {
        title: "",
        code: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/moving-types", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
