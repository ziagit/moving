<template>
  <div>
    <form @submit.prevent="save">
      <md-field class="">
        <label>Name</label>
        <md-input v-model="form.name" required></md-input>
      </md-field>
      <md-field class="">
        <label>Code</label>
        <md-input v-model="form.code" required></md-input>
      </md-field>
      <md-field class="">
        <label>Recommended for</label>
        <md-input v-model="form.recommended" required></md-input>
      </md-field>

      <md-field class="">
        <label>Base fare</label>
        <md-input v-model="form.base_fare" required type="number"></md-input>
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
        name: "",
        code: "",
        recommended: "",
        base_fare: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/vehicle", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
