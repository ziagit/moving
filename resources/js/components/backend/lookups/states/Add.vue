<template>
  <div>
    <form>
      <b-form-group>
        <b-form-input v-model="form.name" placeholder="Name"></b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-select v-model="form.country">
          <option v-for="country in countries" :key="country.id" :value="country.id">
            {{ country.name }}
          </option>
        </b-form-select>
      </b-form-group>
      <b-button variant="primary" v-on:click="save()">Submit</b-button>
    </form>
  </div>
</template>

<script lang="ts">
import axios from "axios";
export default {
  data: () => {
    return {
      form: {
        name: null,
        country: null,
      },
      countries: null,
    };
  },
  methods: {
    save() {
      axios
        .post("admin/states", this.form)
        .then((res) => {
          console.log("saved successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    get() {
      axios
        .get("countries")
        .then((res) => {
          this.countries = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
