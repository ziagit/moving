<template>
  <div class="about">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/about.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <h1>TingsApp</h1>
        <p>
          Everything we trying to do is to solve customer problems through technology.
        </p>
      </div>
    </div>

    <div class="section1">
      <div class="content">
        <div class="left">
          <p>No data available!</p>
          <!-- <div v-html="body"></div> -->
        </div>
        <div class="right">
          <div class="qoute">
            <h5>Get a Free Qoute</h5>
            <form>
              <b-form-group>
                <b-form-input
                  type="text"
                  v-model="form.city"
                  required
                  placeholder="Postalcode"
                ></b-form-input>
              </b-form-group>
              <div class="text-right mt-2">
                <b-button variant="primary" size="sm" @click="$router.push('/')"
                  >Start</b-button
                >
              </div>
            </form>
          </div>
          <div class="faq">
            <h5>Help Center</h5>
            <p class="mb-0">Access to the most asked questions</p>
            <div>
              <b-link @click="$router.push('/help')">Answers</b-link>
              <b-icon icon="arrow-right" variant="primary"></b-icon>
            </div>
          </div>
          <div class="terms">
            <h5>Terms and Conditions</h5>
            <p class="mb-0">Read our terms and conditions</p>
            <div>
              <b-link @click="$router.push('/terms-and-conditions')">More</b-link>
              <b-icon icon="arrow-right" variant="primary"></b-icon>
            </div>
          </div>
          <div class="privacy">
            <h5>Privacy Policies</h5>
            <p class="mb-0">Do you want to know about our privacies?</p>
            <div>
              <b-link @click="$router.push('/privacy-policies')">More</b-link>
              <b-icon icon="arrow-right" variant="primary"></b-icon>
            </div>
          </div>
          <div class="contact">
            <h5>Contact us</h5>
            <p class="mb-0">If you want to know more about us, drop us an email.</p>
            <div>
              <b-link @click="$router.push('/contact')">Contact us</b-link>
              <b-icon icon="arrow-right" variant="primary"></b-icon>
            </div>
          </div>
          <div class="download-app">
            <h5>Download our Applications</h5>
            <p class="mb-0">
              By downloading our application the task will be much easier.
            </p>
            <div class="text-right">
              <b-button-group>
                <b-button
                  variant="success"
                  size="sm"
                  class="mt-2"
                  href="https://play.google.com"
                  >ANDROID</b-button
                >
                <b-button variant="dark" size="sm" class="mt-2" href="https://apple.com"
                  >IPHONE</b-button
                >
              </b-button-group>
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
      .h1 {
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

        .h1 {
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
        .qoute {
          .md-field {
            margin: 4px 0 8px;
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
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .section0 {
    .content {
      padding: 20px !important;
      height: 188px !important;
      .h1 {
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
