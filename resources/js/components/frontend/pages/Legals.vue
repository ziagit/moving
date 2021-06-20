<template>
  <div class="about">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/about.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="md-display-1">TingsApp</div>
        <div class="md-subheading">
          Everything we trying to do is to solve customer problems through technology.
        </div>
      </div>
    </div>

    <div class="section1">
      <div class="wrapper">
        <div class="left">
          <p>No data available!</p>
          <!-- <div v-html="body"></div> -->
        </div>
        <div class="right">
          <div class="qoute">
            <div class="md-title">Get a Free Qoute</div>
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
          <div class="faq">
            <div class="md-title">Help Center</div>
            <div class="md-body-1">Access to the most asked questions</div>
            <div>
              <router-link to="/help">Answers</router-link>
              <md-icon>keyboard_arrow_right</md-icon>
            </div>
          </div>
          <div class="terms">
            <div class="md-title">Terms and Conditions</div>
            <div class="md-body-1">Read our terms and conditions</div>
            <div>
              <router-link to="/terms-and-conditions">More</router-link>
              <md-icon>keyboard_arrow_right</md-icon>
            </div>
          </div>
          <div class="privacy">
            <div class="md-title">Privacy Policies</div>
            <div class="md-body-1">Do you want to know about our privacies?</div>
            <div>
              <router-link to="/privacy-policies">More</router-link>
              <md-icon>keyboard_arrow_right</md-icon>
            </div>
          </div>
          <div class="contact">
            <div class="md-title">Contact us</div>
            <div class="md-body-1">
              If you want to know more about us, drop us an email.
            </div>
            <div>
              <router-link to="/contact">Contact us</router-link>
              <md-icon>keyboard_arrow_right</md-icon>
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
import axios from "axios";
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import localData from "../services/localData";
export default {
  name: "About",
  data: () => ({
    type: "residential",
    form: {
      city: null,
    },
    title: null,
    body: null,
  }),
  methods: {
    get() {
      axios.get("get-about").then((res) => {
        console.log(res.data.body);
        this.title = res.data.title;
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
.about {
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
