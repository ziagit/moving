<template>
  <div class="services">
    <div class="section0">
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <h1>Privacy Notice</h1>
        <p>Read our privacy policy</p>
        <p class="blockquote-footer">Update: June ,2021</p>
      </div>
    </div>
    <div class="section1">
      <div v-html="body"></div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import axio from "axios";
export default {
  name: "services",
  props: ["scrollValue"],
  data: () => ({
    form: {
      city: null,
    },
    title: null,
    body: null,
  }),
  components: {
    Footer,
    Header,
  },
  methods: {
    get() {
      axio.get("get-privacy").then((res) => {
        console.log(res.data.body);
        this.title = res.data.title;
        this.body = res.data.body;
      });
    },
  },
  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.services {
  min-height: 100vh !important;
  background: #fff;

  .section0 {
    .content {
      text-align: center;
      padding: 38px;
    }
  }

  .section1 {
    max-width: 900px;
    margin: auto;
    padding: 30px;
  }
}

@media only screen and (max-width: 600px) {
  .services {
    .section0 {
      text-align: center;

      .md-display-1 {
        line-height: 36px;
        font-size: 30px;
      }
    }

    .div {
      padding: 10px !important;

      .md-display-1 {
        font-size: 30px;
      }
    }
  }
}

// Small devices (landscape phones, less than 768px)
@media (max-width: 767.98px) {
  .services {
    .section0 {
      padding: 64px !important;
    }

    .section1 {
      padding: 0 !important;
    }
  }
}

// Medium devices (tablets, less than 992px)
@media (max-width: 991.98px) {
  .section0 {
    .section1 {
    }

    .md-display-1 {
      line-height: 36px !important;
    }
  }
}

// Large devices (desktops, less than 1200px)
@media (max-width: 1199.98px) {
  .services {
    .section1 {
    }
  }
}
</style>
