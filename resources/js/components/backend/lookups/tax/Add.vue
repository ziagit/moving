<template>
  <form @submit.prevent="save">
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
  data() {
    return {
      form: {
        name: "",
        code: "",
        value: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/constans", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
