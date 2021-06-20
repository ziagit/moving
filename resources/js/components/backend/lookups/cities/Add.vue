<template>
  <div>
    <form @submit.prevent="save()">
      <b-form-group>
        <b-form-input v-model="form.name" name="name" placeholder="Name"></b-form-input>
      </b-form-group>
      <b-form-group>
        <b-form-select v-model="form.state" id="state" placeholder="State">
          <option v-for="state in states" :key="state.id" :value="state.id">
            {{ state.name }}
          </option>
        </b-form-select>
      </b-form-group>

      <b-button type="submit" variant="primary"> Submit </b-button>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import Toaster from "../../../shared/Toaster";
import Vue from "vue";
import axios from "axios";

export default {
  data: () => {
    return {
      form: {
        name: null,
        state: null,
      },
      states: null,
      file: null,
      uploadTogal: false,
      uploading: false,
    };
  },
  methods: {
    isUpload(e) {
      this.uploadTogal = e;
    },
    onFileSelect(e) {
      this.file = e.target.files[0];
      console.log(this.file);
    },
    upload() {
      this.uploading = true;
      let fd = new FormData();
      fd.append("file", this.file);
      axios
        .post("admin/upload-cities", fd)
        .then((res) => {
          console.log("imported: ", res.data, res.status);
          this.$refs.toaster.show(
            "success",
            "b-toaster-top-center",
            "Success",
            res.data.message
          );
          this.uploading = false;
          this.$emit("close-dialog");
        })
        .catch((err) => {
          this.uploading = false;
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            err.response.data.message
          );
          console.log(err.response.data.message);
        });
    },
    save() {
      axios
        .post("admin/cities", this.form)
        .then((res) => {
          console.log("saved successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            err.response.data.message
          );
          console.log("Error: ", err.response);
        });
    },
    get() {
      axios
        .get("admin/states")
        .then((res) => {
          console.log("states lists", res.data.data);
          this.states = res.data.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
  },
  components: {
    Toaster,
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
