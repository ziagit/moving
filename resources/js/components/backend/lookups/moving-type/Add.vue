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
