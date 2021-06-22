<template>
  <div class="how-works">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/about.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <div class="md-display-1">How It Works?</div>
        <div class="md-subheading">Short descripttion about how our system works.</div>
      </div>
    </div>

    <div class="section1">
      <div class="content">
        <div class="left">
          <span>No data available</span>
          <!-- <div v-html="body"></div> -->
        </div>
        <div class="right">
          <div class="qoute">
            <h5>Get a Free Qoute</h5>
            <form>
              <b-form-group>
                <b-form-input type="text" v-model="form.city" required></b-form-input>
              </b-form-group>

              <div class="text-right mt-2">
                <b-button variant="primany" @click="getQuot()" class="tb-30"
                  >Start</b-button
                >
              </div>
            </form>
          </div>
          <div class="faq">
            <h5>Help Center</h5>

            <div>
              <b-link to="/help">Answers</b-link>
              <b-icon variant="primary" carchec></b-icon>
            </div>
          </div>
          <div class="terms">
            <h5>Terms and Conditions</h5>
            <div contacts>Read our terms and conditions</div>
            <div>
              <b-link to="/terms-and-conditions">More</b-link>
              <b-icon variant="primary" carchec></b-icon>
            </div>
          </div>
          <div class="privacy">
            <h5>Privacy Policies</h5>
            <p>Do you want to know about our privacies?</p>
            <div>
              <b-link to="/privacy-policies">More</b-link>
              <b-icon variant="primary" carchec></b-icon>
            </div>
          </div>
          <div class="contact">
            <h5>Contact us</h5>
            <div contacts>If you want to know more about us, drop us an email.</div>
            <div>
              <b-link to="">Contact us</b-link>
              <b-icon variant="primary" carchec></b-icon>
            </div>
          </div>
          <div class="download-app">
            <h5>Download our Application</h5>
            <div m-boddt>
              By dowcontactsg our application the task will be much easier.
            </div>
            <div class="text-right mt-2">
              <b-button variant="primary" size="sm" to="https://play.google.com"
                >Download</b-button
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
.how-works {
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

    .content {
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

        .b-icon {
          color: #66a9fb;
        }

        .qoute {
          .b-form-group {
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
  }
}
</style>
