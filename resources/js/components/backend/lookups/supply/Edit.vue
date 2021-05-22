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
        <label>Price($)</label>
        <md-input v-model="form.price" required type="number" :min="1"></md-input>
      </md-field>
      <md-button type="submit" class="custom-button">Update</md-button>
    </form>
  </div>
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
