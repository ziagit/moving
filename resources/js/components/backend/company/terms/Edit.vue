<template>
  <div>
    <form @submit.prevent="update">
      <md-field class="">
        <label>Title</label>
        <md-input v-model="form.title"></md-input>
      </md-field>
      <tinymce id="d1" v-model="form.body" :init-value="initialValue" ref="tm"></tinymce>
      <br />
      <div class="submit">
        <md-button type="submit" class="custom-button">Update</md-button>
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
  props: ["term"],
  data() {
    return {
      form: {
        title: this.term.title,
        body: "",
      },
      initialValue: "",
    };
  },
  methods: {
    update() {
      axios
        .put("admin/terms/" + this.term.id, this.form)
        .then((res) => {
          console.log("updated: ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => console.log("error: ", err));
    },
  },

  created() {
    this.initialValue = this.term.body;
    console.log("vlaue", this.term);
  },
};
</script>
<style lang="scss" scoped>
.submit {
  text-align: right;
}
</style>
