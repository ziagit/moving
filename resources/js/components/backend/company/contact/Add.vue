<template>
  <div>
    <form>
      <md-card>
        <md-card-content>
          <md-content class="md-layout">
            <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
              <label>Phone</label>
              <md-input v-model="form.phone"></md-input>
            </md-field>
            <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
              <label>Email</label>
              <md-input v-model="form.email"></md-input>
            </md-field>
          </md-content>
        </md-card-content>
        <md-card-actions>
          <md-button v-on:click="save()">Save</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";
export default {
  data: () => {
    return {
      form: {
        phone: null,
        email: null,
      },
    };
  },
  methods: {
    save() {
      axios
        .post("admin/contact", this.form)
        .then((res) => {
          console.log("saved successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>