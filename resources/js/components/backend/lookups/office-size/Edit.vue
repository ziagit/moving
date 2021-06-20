<template>
  <form @submit.prevent="update">
    <b-form-group class="">
      <b-form-input v-model="form.title" required placeholder="Title"></b-form-input>
    </b-form-group>
    <b-form-group class="">
      <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
    </b-form-group>
    <b-form-group class="">
      <b-form-input
        v-model="form.employees"
        required
        placeholder="Employees"
      ></b-form-input>
    </b-form-group>
    <b-form-group class="">
      <b-form-input
        v-model="form.hours_to_move"
        required
        type="number"
        placeholder="Hours to move"
      ></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Update</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  props: ["size"],
  data() {
    return {
      form: {
        title: this.size.title,
        code: this.size.code,
        employees: this.size.employees,
        hours_to_move: this.size.hours_to_move,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/office-sizes/" + this.size.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
