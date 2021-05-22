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
        <label>Moving recommended</label>
        <md-input v-model="form.recommended" required></md-input>
      </md-field>

      <md-field class="">
        <label>Base fare</label>
        <md-input v-model="form.base_fare" required type="number"></md-input>
      </md-field>
      <md-button type="submit" class="custom-button">Update</md-button>
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
