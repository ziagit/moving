<template>
  <div>
    <form>
      <b-form-group
        class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
      >
        <b-form-input v-model="name" name="name" placeholder="Name"></b-form-input>
      </b-form-group>
      <b-form-group
        class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
      >
        <b-form-input v-model="code" name="code" placeholder="Code"></b-form-input>
      </b-form-group>
      <!--    <b-form-group>
              <label>Flag</label>
              <md-file v-model="flag" v-on:change="onFileChange" />
            </b-form-group> -->
      <b-button variant="primary" v-on:click="save()">Submit</b-button>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";
export default Vue.extend({
  data: () => {
    return {
      name: null,
      code: null,
      flag: null,
    };
  },
  methods: {
    onFileChange(e) {
      this.flag = e.target.files[0];
    },

    save() {
      axios
        .post("admin/countries", {
          name: this.name,
          code: this.code,
        })
        .then((res) => {
          console.log("saved successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
});
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
