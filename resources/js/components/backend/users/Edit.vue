<template>
  <div>
    <form @submit.prevent="update">
      <md-field class="">
        <label>Name</label>
        <md-input v-model="form.name" required></md-input>
      </md-field>
      <md-field class="">
        <label>Email</label>
        <md-input v-model="form.email" required></md-input>
      </md-field>
      <md-field class="">
        <label>Password</label>
        <md-input v-model="form.password" required></md-input>
      </md-field>
      <md-field class="">
        <label>Password confirmation</label>
        <md-input v-model="form.password_confirmation" required></md-input>
      </md-field>
      <md-button type="submit" class="md-primary">Update</md-button>
    </form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["user"],
  data() {
    return {
      form: {
        name: this.user.name,
        email: this.user.email,
        password: this.user.password,
        password_confirmation: this.user.password_confirmation,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/users/" + this.user.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("updated: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
<style scoped>
.md-button {
  float: right !important;
}
</style>
