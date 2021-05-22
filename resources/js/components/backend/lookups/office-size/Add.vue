<template>
  <div>
    <form @submit.prevent="save">
      <md-field class="">
        <label>Title</label>
        <md-input v-model="form.title" required></md-input>
      </md-field>
      <md-field class="">
        <label>Code</label>
        <md-input v-model="form.code" required></md-input>
      </md-field>
      <md-field class="">
        <label>Employees</label>
        <md-input v-model="form.employees" required></md-input>
      </md-field>
      <md-field class="">
        <label>Hours to move</label>
        <md-input v-model="form.hours_to_move" required type="number"></md-input>
      </md-field>
      <md-button type="submit" class="custom-button">Save</md-button>
    </form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      form: {
        title: "",
        code: "",
        employees: "",
        hours_to_move: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/office-sizes", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
