<template>
  <div>
    <form @submit.prevent="update">
      <md-field class="">
        <label>Number</label>
        <md-input v-model="form.number" required></md-input>
      </md-field>
      <md-field class="">
        <label>Recommended for</label>
        <md-input v-model="form.recommended" required></md-input>
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
  props: ["mover"],
  data() {
    return {
      form: {
        recommended: this.mover.recommended,
        code: this.mover.code,
        number: this.mover.number,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/mover-number/" + this.mover.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
