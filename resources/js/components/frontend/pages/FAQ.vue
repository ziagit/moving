<template>
  <div class="container">
    <div class="content">
      <div v-html="body"></div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
export default {
  name: "ContactUs",
  data: () => ({
    body: null,
    title: null,
  }),
  methods: {
    get() {
      axios.get("get-faq").then((res) => {
        this.title = res.data.title;
        this.body = res.data.body;
      });
    },
  },
  created() {
    this.get();
  },
  components: {
    Footer,
    Header,
  },
};
</script>

<style lang="scss" scoped>
.container {
  text-align: center;
  img {
    padding: 80px;
    width: 80%;
  }
  .content {
    padding: 60px;
    text-align: left;

    .md-display-1 {
      font-weight: 500;
      line-height: 70px;
      color: #000;
    }

    .md-body-1 {
      font-size: 16px;
      line-height: 24px;
    }
    .steps {
      background: greenyellow;
      .step {
        background: red;
        margin: 10px;
      }
    }
  }
}
</style>
