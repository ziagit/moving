<template>
  <div>
    <form @submit.prevent="save"></form>
    <md-field class="">
      <label>Pate title</label>
      <md-input v-model="form.title"></md-input>
    </md-field>
    <tinymce id="d1" v-model="form.body"></tinymce>
    <md-button type="submit" class="custom-button">Save</md-button>
  </div>
</template>
<script>
import axios from "axios";
import Vue from "vue";
import tinymce from "vue-tinymce-editor";
Vue.component("tinymce", tinymce);
export default {
  data() {
    return {
      form: {
        title: "",
        body: "",
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/help", this.form)
        .then((res) => {
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
