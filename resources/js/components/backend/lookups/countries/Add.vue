<template>
  <div>
    <form>
      <md-card>
        <md-card-content>
          <md-content class="md-layout">
            <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
              <label>Name</label>
              <md-input v-model="name" name="name"></md-input>
            </md-field>
            <md-field class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100">
              <label>Code</label>
              <md-input v-model="code" name="code"></md-input>
            </md-field>
         <!--    <md-field>
              <label>Flag</label>
              <md-file v-model="flag" v-on:change="onFileChange" />
            </md-field> -->
          </md-content>
        </md-card-content>
        <md-card-actions>
          <md-button v-on:click="save()">Submit</md-button>
        </md-card-actions>
      </md-card>
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
      this.flag = e.target.files[0]
    },
 
    save() {
      axios.post("admin/countries", {
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