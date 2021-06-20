<template>
  <div>
    <form>
      <b-form-group
        class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
      >
        <b-form-input placeholder="Name" v-model="form.name"></b-form-input>
      </b-form-group>
      <b-form-group
        class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
      >
        <b-form-input placeholder="Code" v-model="form.code"></b-form-input>
      </b-form-group>
      <b-button variant="primary" v-on:click="update()">Update</b-button>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import Axios from "axios";
export default {
  props: ["country"],
  data: () => ({
    form: {
      name: null,
      code: null,
    },
  }),
  methods: {
    update() {
      Axios.put("admin/countries/" + this.country.id, this.form)
        .then((res) => {
          console.log("updated successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.form = this.country;
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
