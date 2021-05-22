<template>
  <div>
    <form>
      <md-card>
        <md-card-content>
          <md-content class="md-layout">
            <md-field
              class="md-layout-item md-large-size-100 md-small-size-100 md-xsmall-size-100"
            >
              <md-input v-model="form.name" placeholder="Name"></md-input>
            </md-field>
            <md-field>
              <md-select v-model="form.state" placeholder="State" id="state">
                <md-option v-for="state in states" :key="state.id" :value="state.id">{{
                  state.name
                }}</md-option>
              </md-select>
            </md-field>
          </md-content>
        </md-card-content>
        <md-card-actions>
          <md-button v-on:click="update()">Done</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script lang="ts">
import axios from "axios";
export default {
  props: ["city"],
  data: () => {
    return {
      form: {
        name: null,
        state: null,
      },
      states: null,
    };
  },
  methods: {
    update() {
      axios
        .put("admin/cities/" + this.city.id, this.form)
        .then((res) => {
          console.log("Updated successfully! ", res.data);
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    get() {
      axios
        .get("states")
        .then((res) => {
          this.states = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
    this.form.name = this.city.name;
    this.form.state = this.city.state.id;
  },
};
</script>

<style scoped>
.md-card {
  box-shadow: none;
}
</style>
