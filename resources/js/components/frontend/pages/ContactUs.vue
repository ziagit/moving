<template>
  <div class="cities">
    <div class="section0">
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d31958839.600046597!2d-128.4053053!3d60.7318475!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x537a66c7aa6b6aaf%3A0x881b41e937e7f1f9!2sBritish%20Columbia%2C%20Canada!5e0!3m2!1sen!2s!4v1603098152028!5m2!1sen!2s"
        width="600"
        height="278"
        frameborder="0"
        style="border: 0"
        allowfullscreen=""
        aria-hidden="false"
        tabindex="0"
      ></iframe>
    </div>
    <div class="section1">
      <div class="wrapper">
        <div class="left">
          <div class="md-display-1">Drop us a line</div>
          <form @submit.prevent="submit" action="">
            <md-field>
              <label>Name</label>
              <md-input v-model="form.name" type="text" required></md-input>
            </md-field>
            <md-field>
              <label>Email</label>
              <md-input v-model="form.email" type="text" required></md-input>
            </md-field>

            <md-field>
              <label>Message</label>
              <md-textarea v-model="form.message" required></md-textarea>
            </md-field>

            <md-button type="submit" slot="right" class="custom-button">Send</md-button>
          </form>
        </div>
        <div class="right">
          <div class="content">
            <img :src="'/images/uploads/location.svg'" alt="2" width="80" />
            <div class="md-caption">Sheer Pur Main Road,</div>
            <div class="md-caption">1001, Kabul</div>
            <div class="md-caption">Afghanistan</div>
            <div class="break"></div>
            <div class="md-caption">+1 (604) 358-6261</div>
          </div>
        </div>
      </div>
    </div>
    <Toaster ref="toaster" />
    <Footer />
  </div>
</template>

<script>
import Toaster from "../../shared/Toaster";
import Footer from "../../shared/Footer";
import Header from "../../shared/Header";
import axios from "axios";
export default {
  name: "ContactUs",
  components: {
    Toaster,
    Footer,
    Header,
  },
  data: () => ({
    form: {
      name: null,
      email: null,
      message: null,
    },
  }),
  methods: {
    submit() {
      axios
        .post("about-form", this.form)
        .then((res) => {
          this.$refs.toaster.show(
            "success",
            "b-toaster-top-center",
            "Success",
            "Thanks for contacting us!"
          );

          this.form.name = null;
          this.form.email = null;
          this.form.message = null;
          console.log("thanks for contacting", res.data);
        })
        .catch((err) => {
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            "There is something wrong, please try again!"
          );
          console.log("something wrong");
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.cities {
  background: #fff;
  iframe {
    left: 0;
    top: 0;
    height: 268px;
    width: 100%;
  }

  .section1 {
    max-width: 1200px;
    margin: auto;
    padding: 30px;
    .wrapper {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;

      .left {
        flex: 60%;
        padding: 60px;

        .md-display-1 {
          font-weight: 500;
          line-height: 70px;
          color: #000;
        }

        .md-button {
          float: right;
        }
      }

      .right {
        flex: 30%;
        padding: 82px 60px;

        .content {
          text-align: center;

          .md-headline {
            font-size: 18px;
          }
          img {
            margin: 30px;
          }
          .md-caption {
          }
        }
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .md-card {
    flex-direction: column;
    margin-bottom: 30px;
    margin: auto;
    padding: 0 !important;

    .left {
      text-align: center;
      align-items: center;

      .md-button {
        margin: 0;
      }
    }

    .md-display-1 {
      font-size: 30px;
    }
  }
}
</style>
