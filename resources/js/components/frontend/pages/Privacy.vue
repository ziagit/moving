<template>
  <div class="services">
    <div class="section0">
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="md-display-1">Privacy Notice</div>
        <div class="md-body-1">Read our privacy policy</div>
        <div class="break"></div>
        <div class="md-body-1 update">Update: October 25,2020</div>
      </div>
    </div>
    <div class="section1">
      <div class="wrapper">
        <div class="left">
          <div v-html="body"></div>
        </div>
      </div>
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

      .md-display-1 {
        line-height: 60px;
        font-size: 53px;
        font-weight: 600;
        color: #000;
      }
      .update {
        color: #c3c0c0;
      }
    }
  }

  .section1 {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    .wrapper {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;

      .left {
        flex: 60%;
        padding: 60px;

        .md-display-1 {
          font-weight: 500;
          line-height: 70px;
          color: #000;
        }

        .md-body-1 {
          font-size: 16px;
          line-height: 24px;
        }
      }

      .right {
        flex: 30%;
        padding: 82px 60px;

        .md-icon {
          color: #66a9fb;
        }

        .qoute {
          .md-field {
            margin: 4px 0 8px;
          }

          .action {
            text-align: right;

            .md-button {
              margin: 0;
            }
          }
        }

        .qoute,
        .faq,
        .download-app,
        .privacy,
        .terms,
        .contact {
          margin-bottom: 30px;
        }

        .download-app {
          .md-button {
            margin-top: 20px;
          }
        }
      }
    }
  }
}

.md-body-1 {
  width: 100% !important;
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
