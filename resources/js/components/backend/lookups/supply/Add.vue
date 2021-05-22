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
        <label>Price($)</label>
        <md-input v-model="form.price" required type="number"></md-input>
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
        number: "",
        price: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/supply", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
