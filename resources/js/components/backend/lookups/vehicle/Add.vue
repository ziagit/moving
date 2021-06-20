<template>
  <div>
    <form @submit.prevent="save">
      <b-form-group class="">
        <b-form-input v-model="form.name" required placeholder="Name"></b-form-input>
      </b-form-group>
      <b-form-group class="">
        <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
      </b-form-group>
      <b-form-group class="">
        <b-form-input
          v-model="form.recommended"
          required
          placeholder="Recommended for"
        ></b-form-input>
      </b-form-group>

      <b-form-group class="">
        <b-form-input
          v-model="form.base_fare"
          required
          type="number"
          placeholder="Base fare"
        ></b-form-input>
      </b-form-group>
      <b-button type="submit" variant="primary">Save</b-button>
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
