<template>
  <form @submit.prevent="update">
    <b-form-group>
      <b-form-input v-model="form.number" required></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input v-model="form.recommended" required></b-form-input>
    </b-form-group>
    <b-form-group>
      <label>Code</label>
      <b-form-input v-model="form.code" required></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Update</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  props: ["mover"],
  data() {
    return {
      form: {
        recommended: this.mover.recommended,
        code: this.mover.code,
        number: this.mover.number,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/mover-number/" + this.mover.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
