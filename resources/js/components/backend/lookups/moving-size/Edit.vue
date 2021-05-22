<template>
  <div>
    <form @submit.prevent="update">
      <md-field class="">
        <label>Title</label>
        <md-input v-model="form.title" required></md-input>
      </md-field>
      <md-field class="">
        <label>Code</label>
        <md-input v-model="form.code" required></md-input>
      </md-field>
      <md-field class="">
        <label>Size</label>
        <md-input v-model="form.recommended" required></md-input>
      </md-field>
      <md-field class="">
        <label>Hours to move</label>
        <md-input type="number" :min="1" v-model="form.hours_to_move" required></md-input>
      </md-field>
      <md-button type="submit" class="custom-button">Update</md-button>
    </form>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["size"],
  data() {
    return {
      form: {
        title: this.size.title,
        code: this.size.code,
        recommended: this.size.recommended,
        hours_to_move: this.size.hours_to_move,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/moving-size/" + this.size.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
