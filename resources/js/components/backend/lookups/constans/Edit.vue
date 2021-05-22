<template>
  <div>
    <form @submit.prevent="update">
      <md-field class="">
        <label>Name</label>
        <md-input v-model="form.name" required></md-input>
      </md-field>
      <md-field class="">
        <label>Code</label>
        <md-input v-model="form.code" required></md-input>
      </md-field>
      <md-field class="">
        <label>value</label>
        <md-input type="number" :min="1" v-model="form.value" required></md-input>
      </md-field>

      <md-button type="submit" class="custom-button">Update</md-button>
    </form>
  </div>
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
