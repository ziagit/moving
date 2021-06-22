<template>
  <div class="carriers">
    <div
      class="section0"
      v-bind:style="{
        'background-image': 'url(/images/uploads/carrier-bg.svg)',
      }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="md-display-1">Become a Mover</div>

        <div class="md-subheading">
          Join our mover networks by creating an account with us.
        </div>
        <div class="break"></div>
        <div class="break"></div>
        <b-button variant="primary" @click="$router.push('/register')">Sign Up</b-button>
      </div>
    </div>

    <div class="section1">
      <div class="wrapper">
        <div class="left">
          <p>Not available!</p>
          <!-- <div v-html="body"></div> -->
        </div>
        <div class="right">
          <div class="download-app">
            <h5>Download our Application</h5>
            <div class="md-body-1">
              By downloading our application the task will be much easier.
            </div>
            <div class="mt-3">
              <b-button variant="primary" @click="Window.open('https://play.google.com')"
                >Download</b-button
              >
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="section2">
      <div class="rows">
        <div class="row">
          <img :src="'/images/uploads/carrier-tech.svg'" width="30" alt="" />
          <div>
            <h5>Carrier Technology</h5>
            <div class="md-body-1">Easy to use tools to find freight.</div>
          </div>
        </div>
        <div class="row">
          <img :src="'/images/uploads/carrier-payment.svg'" width="30" alt="" />
          <div>
            <h5>Get Paid</h5>
            <div class="md-body-1">
              Get paid fast with options to further speed the process.
            </div>
          </div>
        </div>
        <div class="row">
          <img :src="'/images/uploads/carrier-freight.svg'" width="50" alt="" />
          <div>
            <h5>Carrier Programs</h5>
            <div class="md-body-1">
              Personalized service and more freight opportunities.
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import axios from "axios";
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
export default {
  name: "Carrier",
  data: () => ({
    form: {
      name: null,
      email: null,
      message: null,
    },
    title: null,
    body: null,
  }),
  methods: {
    get() {
      axios.get("get-carrier-page").then((res) => {
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
.carriers {
  background: #fff;

  .section0 {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    align-items: center;
    border-bottom: #ddd 1px solid;
    .content {
      height: 268px;
      padding: 85px 200px 85px 106px;

      .md-display-1 {
        line-height: 60px;
        font-size: 53px;
        font-weight: 600;
        color: #000;
      }

      .md-subheading {
        color: #000;
        max-width: 70%;
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

        .md-headline {
          font-size: 22px;
        }

        .md-icon {
          color: #66a9fb;
        }

        .qoute {
          .md-field {
            margin: 4px 0 8px;
          }

          .action {
            text-align: right;

            .b-button {
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
          .b-button {
            margin-top: 20px;
          }
        }
      }
    }
  }

  .section2 {
    padding: 0 100px 46px 100px;

    .rows {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;

      .row {
        flex: 30%;
        padding: 30px;
        border: solid 1px #ddd;
        border-radius: 3px;
        margin: 10px;
        text-align: center;

        .md-title {
          line-height: 52px;
          font-weight: 600;
          line-height: 44px;
        }
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .section0 {
    .content {
      padding: 20px !important;
      height: 188px !important;
      .md-display-1 {
        font-size: 32px !important;
        line-height: 48px !important;
      }
      .md-subheading {
        font-size: 14px !important;
      }
    }
  }

  .section1 {
    padding: 30 !important;

    .wrapper {
      flex-direction: column;
      .left,
      .right {
        padding: 0 !important;
      }
      .left {
        margin-bottom: 74px !important;
      }
      .b-button {
        margin: 30px 0 0 0;
      }
    }
  }
  .section2 {
    padding: 44px !important;
  }
}
</style>
