<template>
  <div>
    <form @submit.prevent="update"></form>
    <md-field class="">
      <label>Pate title</label>
      <md-input v-model="form.title"></md-input>
    </md-field>
    <tinymce id="d1" v-model="form.body"></tinymce>
    <md-button type="submit" class="custom-button">Update</md-button>
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
        .put("admin/privacy/" + privacy.id, this.form)
        .then((res) => {
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
