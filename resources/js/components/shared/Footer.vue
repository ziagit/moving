<template>
  <div class="footer">
    <div class="rows">
      <div class="row">
        <ul>
          <li>
            <a @click="navigate('/')"><b>Home</b></a>
          </li>
          <li>
            <a @click="navigate('/about')"><b>What is TingsApp</b></a>
          </li>
          <li>
            <a @click="navigate('/help')"><b>How it Works</b> </a>
          </li>
          <li>
            <a @click="navigate('/help')"><b>Help center</b> </a>
          </li>
          <li>
            <a @click="navigate('/cities')"><b>Cities</b></a>
          </li>
        </ul>
      </div>
      <div class="row">
        <ul>
          <li>
            <a @click="navigate('/help')"><b>Become a Mover</b></a>
          </li>
          <li>
            <a @click="navigate('/login')"><b>My account</b></a>
          </li>
        </ul>
      </div>
      <div class="row app">
        <div>
          <a @click="external('https://apple.com')"
            ><img :src="'/images/uploads/apple-store.svg'" alt="" width="120"
          /></a>
        </div>
        <div>
          <a @click="external('https://play.google.com')"
            ><img :src="'/images/uploads/google-play.svg'" alt="" width="120"
          /></a>
        </div>
      </div>
    </div>
    <div class="line"></div>
    <div class="bottom">
      <span class="col0"
        ><span>© TingsApp.</span>
        <span class="tp">
          <a @click="navigate('/terms-and-conditions')">Terms</a> |
          <a @click="navigate('/privacy-policies')">Privacy</a>
        </span>
      </span>
      <span class="col2">
        <div class="row social-media">
          <div class="icons">
            <a @click="external('https://facebook.com')"
              ><img :src="'/images/uploads/facebook.svg'" alt="" width="30"
            /></a>
            <a @click="external('https://linkedin.com')"
              ><img :src="'/images/uploads/linkedin.svg'" alt="" width="30"
            /></a>
            <a @click="external('https://twitter.com')"
              ><img :src="'/images/uploads/twitter.svg'" alt="" width="30"
            /></a>
          </div>
        </div>
      </span>
    </div>
  </div>
</template>

<script>
export default {
  name: "Footer",
  methods: {
    navigate(path) {
      this.$router.push(path);
      window.scrollTo(0, 0);
    },
    external(path) {
      window.open(path, "_blank");
    },
  },
};
</script>

<style lang="scss" scoped>
.footer {
  background: #edf3ff;
  min-height: 150px;

  .rows {
    max-width: 1200px;
    margin: auto;
    padding: 56px 92px;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .social-media {
      .logo {
        font-family: "Segoe Script", Helvetica, Arial;
        font-size: 20px;
      }

      .md-body-1 {
        width: 60% !important;
      }
    }

    .row {
      flex: 25%;

      .md-headline {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 12px;
      }

      .icons {
        display: flex;
        justify-content: space-between;
        max-width: 110px;
        margin-top: 36px;
      }

      ul {
        padding: 0;
        margin: 0;

        li {
          list-style-type: none;
          margin-bottom: 8px;

          a {
            color: #21201e;
          }
        }
      }
    }

    .app {
      flex-direction: column !important;
      text-align: right;
      div {
        margin-bottom: 10px;
      }
    }
  }
  .line {
    border-top: solid 0.5px #fff;
  }
  .bottom {
    max-width: 1200px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 82px;

    color: rgb(121, 120, 120);

    span {
      a {
        color: rgb(121, 120, 120);
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .footer {
    .rows {
      padding: 46px 46px;

      .row {
        flex: 100% !important;
        margin-bottom: 26px;
      }
    }

    .bottom {
      padding: 10px !important;

      span {
        font-size: 8px;
      }
      .tp {
        margin-left: 5px;
      }
      .social-media {
        img {
          width: 20px;
        }
      }
    }
    .app {
      text-align: left !important;
    }
  }
}
</style>
