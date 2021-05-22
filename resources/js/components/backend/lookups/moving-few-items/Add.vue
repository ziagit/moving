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
        <label>Time to move (minute)</label>
        <md-input type="number" :min="1" v-model="form.hours_to_move" required></md-input>
      </md-field>
      <md-field class="">
        <label>Disposal fee ($)</label>
        <md-input type="number" :min="1" v-model="form.disposal_fee" required></md-input>
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
        hours_to_move: "",
        disposal_fee: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/few-items", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
