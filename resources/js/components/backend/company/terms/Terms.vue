<template>
  <div class="container">
    <Edit v-if="togal" v-on:close-dialog="refresh" :term="terms" />
    <div v-else>
      <b-card v-if="terms" header="Terms" class="border-0 shadow mt-5 mb-5">
        <div>{{ terms.title }}</div>
        <div v-html="terms.body"></div>
        <b-button class="add-btn" variant="primary" @click="togal = true">
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
  name: "term",
  data: () => ({
    terms: null,
    togal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/terms")
        .then((res) => {
          console.log(res.data);
          this.terms = res.data;
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
