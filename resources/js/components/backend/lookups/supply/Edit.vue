<template>
  <form @submit.prevent="update">
    <b-form-group>
      <b-form-input v-model="form.name" required placeholder="Name"></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input
        v-model="form.price"
        required
        type="number"
        placeholder="Price($)"
      ></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Save</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  props: ["supply"],
  data() {
    return {
      form: {
        name: this.supply.name,
        code: this.supply.code,
        price: this.supply.price,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/supply/" + this.supply.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
