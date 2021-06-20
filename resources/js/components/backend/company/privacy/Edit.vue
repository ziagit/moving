<template>
  <div class="container">
    <b-card class="shadow border-0 mt-5 mb-5">
      <form @submit.prevent="update">
        <b-form-group class="">
          <b-form-input v-model="form.title" placeholder="Title"></b-form-input>
        </b-form-group>
        <tinymce id="d1" v-model="form.body"></tinymce>
        <div class="text-right">
          <b-button type="submit" variant="primary mt-3">Update</b-button>
        </div>
      </form>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
import Vue from "vue";
import tinymce from "vue-tinymce-editor";
Vue.component("tinymce", tinymce);
export default {
  props: ["privacy"],
  data() {
    return {
      form: {
        title: this.privacy.title,
        body: this.privacy.body,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/privacy/" + this.privacy.id, this.form)
        .then((res) => {
          console.log("saved: ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
