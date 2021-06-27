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
        <h1>Become a Mover</h1>

        <p>Join our mover networks by creating an account with us.</p>
        <div class="break"></div>
        <div class="break"></div>
        <b-button variant="primary" @click="$router.push('/register')">Sign Up</b-button>
      </div>
    </div>

    <div class="container pt-5">
      <div class="row">
        <div class="col-9">
          <p>Not available!</p>
          <!-- <div v-html="body"></div> -->
        </div>
        <div class="col-3">
          <div class="download-app">
            <h5>Download our Application</h5>
            <p>By downloading our application the task will be much easier.</p>
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
      <br />
      <br />
      <div class="row d-flex justify-content-between">
        <div class="col-3 text-center">
          <img :src="'/images/uploads/carrier-tech.svg'" width="30" alt="" />
          <div>
            <h5>Carrier Technology</h5>
            <p>Easy to use tools to find freight.</p>
          </div>
        </div>
        <div class="col-3 text-center">
          <img :src="'/images/uploads/carrier-payment.svg'" width="30" alt="" />
          <div>
            <h5>Get Paid</h5>
            <p>Get paid fast with options to further speed the process.</p>
          </div>
        </div>
        <div class="col-3 text-center">
          <img :src="'/images/uploads/carrier-freight.svg'" width="50" alt="" />
          <div>
            <h5>Carrier Programs</h5>
            <p>Personalized service and more freight opportunities.</p>
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
    }
  }

  .section2 {
    .col-3 {
      border: solid 1px #ddd;
      padding: 10px;
      margin: 5px;
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

    .my-wrapper {
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
