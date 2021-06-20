<template>
  <div class="shippers">
    <div
      class="section0"
      v-bind:style="{
        'background-image': 'url(/images/uploads/shipper-bg.svg)',
      }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="md-display-1">Our Customers</div>
        <div class="md-subheading">We are committed to our customer satisfaction.</div>
        <div class="break"></div>
        <div class="break"></div>
        <md-button class="custom-button">Move now</md-button>
      </div>
    </div>

    <div class="section1">
      <div class="wrapper">
        <div class="left">
          <div v-html="body"></div>
        </div>
        <div class="right">
          <div class="qoute">
            <div class="md-title">Get a Free Quote</div>
            <form>
              <md-field>
                <label>Postal code</label>
                <md-input type="text" v-model="form.city" required></md-input>
              </md-field>
              <div>What kind of moving is it?</div>
              <div>
                <md-radio v-model="type" value="residential">
                  <small>Residential</small></md-radio
                >
                <md-radio v-model="type" value="office"><small>Office</small></md-radio>
              </div>

              <div class="action">
                <md-button class="custom-button" @click="getQuot()">Start</md-button>
              </div>
            </form>
          </div>

          <div class="contact">
            <div class="bunner">
              <div class="md-body-1">
                Whether you're an experienced or novice shipper, we have the tools and
                experts to help you plan and execute complex or simple shipping solutions.
              </div>
            </div>
          </div>
          <div class="download-app">
            <div class="md-title">Download our Application</div>
            <div class="md-body-1">
              By downloading our application the task will be much easier.
            </div>
            <div>
              <md-button class="custom-button" to="https://play.google.com"
                >Download</md-button
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import axio from "axios";
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import localData from "../services/localData";
export default {
  name: "Shipper",
  data: () => ({
    type: "residential",
    form: {
      name: null,
      email: null,
      message: null,
    },
    body: null,
    title: null,
  }),
  methods: {
    get() {
      axios.get("get-shipper-page").then((res) => {
        this.body = res.data.body;
      });
    },
    getQuot() {
      localData.save("type", this.type);
      this.$router.push("/order/from");
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
.shippers {
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

        img {
          width: 100%;
          //box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
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

            .md-button {
              margin: 0;
            }
          }
        }

        .qoute,
        .download-app,
        .contact,
        .bunner {
          margin-bottom: 30px;
        }
        .bunner {
          background: #ffa50066;
          padding: 20px;
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
      .md-button {
        margin: 30px 0 0 0;
      }
    }
  }
}
</style>
