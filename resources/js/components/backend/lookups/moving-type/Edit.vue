<template>
  <div>
    <form @submit.prevent="update">
      <md-field class="">
        <label>Title</label>
        <md-input v-model="form.title" required></md-input>
      </md-field>
      <md-field class="">
        <label>Code</label>
        <md-input v-model="form.code" required></md-input>
      </md-field>
      <md-button type="submit" class="custom-button">Update</md-button>
    </form>
  </div>
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
