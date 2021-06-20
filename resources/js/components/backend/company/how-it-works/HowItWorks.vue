<template>
  <div class="container">
    <Edit v-if="togal" v-on:close-dialog="refresh" :help="help" />
    <div v-else>
      <b-card v-if="help" header="Help Page" class="border-0 shadow mt-5 mb-5">
        <div>{{ help.title }}</div>
        <div v-html="help.body"></div>
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
  name: "help",
  data: () => ({
    help: null,
    togal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/how-it-works")
        .then((res) => {
          console.log("help", res.data);
          this.help = res.data;
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
