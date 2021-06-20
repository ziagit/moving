<template>
  <form @submit.prevent="update">
    <b-form-group>
      <b-form-input v-model="form.name" required placeholder="Name"></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input v-model="form.code" required placeholder="Code"></b-form-input>
    </b-form-group>
    <b-form-group>
      <label></label>
      <b-form-input
        type="number"
        :min="1"
        v-model="form.hours_to_move"
        required
        placeholder="Time to move (minute)"
      ></b-form-input>
    </b-form-group>
    <b-form-group>
      <b-form-input
        type="number"
        :min="1"
        v-model="form.disposal_fee"
        required
        placeholder="Disposal fee ($)"
      ></b-form-input>
    </b-form-group>
    <b-button type="submit" variant="primary">Update</b-button>
  </form>
</template>
<script>
import axios from "axios";
export default {
  props: ["item"],
  data() {
    return {
      form: {
        name: this.item.name,
        code: this.item.code,
        hours_to_move: this.item.moving_cost,
        disposal_fee: this.item.disposal_fee,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/few-items/" + this.item.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
