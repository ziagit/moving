<template>
  <div>
    <form>
      <b-form-group>
        <b-form-input v-model="form.name" placeholder="Name"></b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-select v-model="form.state" placeholder="State" id="state">
          <option v-for="state in states" :key="state.id" :value="state.id">
            {{ state.name }}
          </option>
        </b-form-select>
      </b-form-group>
      <b-button variant="primary" v-on:click="update()">Done</b-button>
    </form>
  </div>
</template>

<script lang="ts">
import axios from "axios";
export default {
  props: ["city"],
  data: () => {
    return {
      form: {
        name: null,
        state: null,
      },
      states: null,
    };
  },
  methods: {
    update() {
      axios
        .put("admin/cities/" + this.city.id, this.form)
        .then((res) => {
          console.log("Updated successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    get() {
      axios
        .get("states")
        .then((res) => {
          this.states = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
    this.form.name = this.city.name;
    this.form.state = this.city.state.id;
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
