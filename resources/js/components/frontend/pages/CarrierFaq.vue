<template>
  <div class="faq">
    <div class="left">
      <h1>Carrier</h1>
      <p>
        Ask us anything! When you need assistance, our knowledgeable experts are ready.
        Here are some common situations along with guidance we’re pleased to share with
        you.
      </p>
      <br />
      <infoList v-for="(item, index) in dynamicList" :key="index" :list="item">
        <div v-html="item.body"></div>
      </infoList>
    </div>
    <div class="right">
      <div class="contact">
        <h5>Contact us</h5>
        <p>If you want to know more about us, drop us an email.</p>
        <div>
          <router-link to="/contact">Contact us</router-link>
          <md-icon>keyboard_arrow_right</md-icon>
        </div>
      </div>
      <div class="download-app">
        <h5>Download our Application</h5>
        <p>By downloading our application the task will be much easier.</p>
        <div>
          <b-button @click="Window.open('https://play.google.com')">Download</b-button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Axios from "axios";
import InfoList from "../../shared/AccordionList";
export default {
  data: () => ({
    dynamicList: [],
  }),
  methods: {
    get() {
      Axios.get("get-carrier-faq").then((res) => {
        let list = res.data;
        list.forEach((element) => {
          this.dynamicList.push({ ...element, visible: false });
        });
      });
    },
  },
  created() {
    this.get();
  },
  components: { InfoList },
};
</script>
<style scoped lang="scss">
.faq {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  padding: 0;
  .left {
    flex: 60%;
    padding: 60px;

    .md-display-1 {
      font-weight: 500;
      line-height: 70px;
      color: #000;
    }
    .text-16 {
      font-size: 16px;
      line-height: 24px;
    }
  }

  .right {
    flex: 30%;
    padding: 80px 60px;

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
@media only screen and (max-width: 600px) {
  .left {
    padding: 0 !important;
  }
}
</style>
