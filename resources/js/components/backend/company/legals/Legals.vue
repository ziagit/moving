<template>
  <div class="container">
    <Edit v-if="togal" v-on:close-dialog="refresh" :legals="legals" />
    <div v-else>
      <b-card v-if="legals" header="Customer Page" class="border-0 shadow mt-5 mb-5">
        <div>{{ legals.title }}</div>
        <div v-html="legals.body"></div>
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
  name: "Legals",
  data: () => ({
    legals: null,
    togal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/legals")
        .then((res) => {
          console.log("legals page", res.data);
          this.legals = res.data;
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
