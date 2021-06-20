<template>
  <div class="container">
    <Edit v-if="togal" v-on:close-dialog="refresh" :about="about" />
    <div v-else>
      <b-card v-if="about" class="border-0 shadow mt-5 mb-5" header="What is TingsApp">
        <div>{{ about.title }}</div>
        <div v-html="about.body"></div>
        <b-button variant="primary" class="add-btn" @click="togal = true">
          <b-icon icon="pencil"></b-icon>
        </b-button>
      </b-card>
    </div>
  </div>
</template>

<script>
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "about",
  data: () => ({
    about: null,
    togal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/about")
        .then((res) => {
          console.log("res", res.data);
          this.about = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    refresh() {
      this.togal = false;
      this.get();
    },
  },
  created() {
    this.get();
  },

  components: {
    Edit,
  },
};
</script>
<style scoped lang="scss">
.container {
  min-height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
