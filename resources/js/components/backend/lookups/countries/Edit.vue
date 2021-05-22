<template>
  <div>
    <form>
      <md-card>
        <md-card-content>
          <md-content class="md-layout">
            <md-field
              class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
            >
              <label>Name</label>
              <md-input v-model="form.name"></md-input>
            </md-field>
            <md-field
              class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
            >
              <label>Code</label>
              <md-input v-model="form.code"></md-input>
            </md-field>
          </md-content>
        </md-card-content>
        <md-card-actions>
          <md-button v-on:click="update()">Update</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import Axios from "axios";
export default {
  props: ["country"],
  data: () => ({
    form: {
      name: null,
      code: null,
    },
  }),
  methods: {
    update() {
      Axios.put("admin/countries/" + this.country.id, this.form)
        .then((res) => {
          console.log("updated successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.form = this.country;
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
