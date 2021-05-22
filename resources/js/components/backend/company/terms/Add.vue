<template>
  <div>
    <form @submit.prevent="save">
      <md-field class="">
        <label>Page title</label>
        <md-input v-model="form.title"></md-input>
      </md-field>
      <tinymce id="d1" v-model="form.body"></tinymce>
      <br />
      <div class="submit">
        <md-button type="submit" class="custom-button">Save</md-button>
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
      console.log("xxxxxxxx");
      axios
        .post("admin/terms", this.form)
        .then((res) => {
          console.log("saved: ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
<style lang="scss" scoped>
.submit {
  text-align: right;
}
</style>
