<template>
  <div>
    <form @submit.prevent="save">
      <b-form-group class="">
        <b-form-input v-model="form.title" placeholder="Title"></b-form-input>
      </b-form-group>
      <tinymce id="d1" v-model="form.body"></tinymce>
      <div class="text-right">
        <b-button type="submit" variant="primary mt-3">Submit</b-button>
      </div>
    </form>
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
        .post("admin/carrier-faq", this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
