<template>
  <form @submit.prevent="update">
    <b-form-group>
      <b-form-input v-model="form.name" required placeholder="Name"></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input
        type="number"
        :min="1"
        v-model="form.value"
        required
        placeholder="Value"
      ></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Save</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  props: ["cons"],
  data() {
    return {
      form: {
        name: this.cons.name,
        code: this.cons.code,
        value: this.cons.value,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/constans/" + this.cons.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
