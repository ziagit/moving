<template>
  <div>
    <form @submit.prevent="update">
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
  props: ["vehicle"],
  data() {
    return {
      form: {
        name: this.vehicle.name,
        code: this.vehicle.code,
        recommended: this.vehicle.recommended,
        base_fare: this.vehicle.base_fare,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/vehicle/" + this.vehicle.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
