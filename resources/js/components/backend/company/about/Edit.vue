<template>
  <div class="container">
    <b-card class="shadow border-0 mt-5 mb-5">
      <form @submit.prevent="update"></form>
      <b-form-group class="">
        <b-form-input v-model="form.title" placeholder="Title"></b-form-input>
      </b-form-group>
      <tinymce id="d1" v-model="form.body"></tinymce>
      <div class="text-right">
        <b-button type="submit" variant="primary mt-3">Update</b-button>
      </div>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
import Vue from "vue";
import tinymce from "vue-tinymce-editor";
Vue.component("tinymce", tinymce);
export default {
  props: ["about"],
  data() {
    return {
      form: {
        title: this.about.title,
        body: this.about.body,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/about/" + about.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
<style>
.container {
  min-height: calc(100vh - 50px);
}
</style>
