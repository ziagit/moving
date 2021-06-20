<template>
  <div>
    <form @submit.prevent="update">
      <b-form-group class="">
        <b-form-input v-model="form.title" placeholder="Title"></b-form-input>
      </b-form-group>
      <tinymce id="d1" v-model="form.body"></tinymce>
      <div class="text-right">
        <b-button type="submit" variant="primary mt-3">Update</b-button>
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
  props: ["shipper"],
  data() {
    return {
      form: {
        title: this.shipper.title,
        body: this.shipper.body,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/shipper-faq/" + this.shipper.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
          console.log("saved: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
