<template>
  <div class="cities">
    <div
      class="section0"
      v-bind:style="{
        'background-image': 'url(/images/uploads/cities.svg)',
      }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" />
      <div class="content">
        <h1>Cities</h1>
        <p>List of cities under our services.</p>
      </div>
    </div>

    <div class="section1">
      <div class="my-wrapper">
        <div class="left">
          <h4>Cities Under Our Service Coverage</h4>
          <ul>
            <li v-for="country in countries" :key="country.id">
              <div class="content">
                <img :src="'/images/uploads/green-checked.svg'" width="20" alt="" />
                <div class="md-body-2">{{ country.name }}</div>
              </div>
              <ul>
                <li v-for="state in country.states_and_cities" :key="state.id">
                  <div class="content">
                    <img :src="'/images/uploads/green-checked.svg'" width="20" alt="" />
                    <div class="md-body-2">{{ state.name }}</div>
                  </div>
                  <ul>
                    <li v-for="city in state.cities" :key="city.id">
                      <div class="content">
                        <img
                          :src="'/images/uploads/green-checked.svg'"
                          width="20"
                          alt=""
                        />
                        <div class="md-body-2">{{ city.name }}</div>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <div class="right">
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
    countries: null,
  }),
  methods: {
    get() {
      axios.get("countries-full").then((res) => {
        console.log("countries ", res.data);
        this.countries = res.data;
      });
    },
    open() {
      window.open("https://play.google.com");
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
.cities {
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

    .my-wrapper {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;

      .left {
        flex: 60%;
        padding: 60px;

        ul {
          li {
            list-style-type: none;

            .content {
              font-size: 18px;
              display: flex;
              margin: 5px;
              align-items: center;
              img {
                margin: 5px;
              }
            }
          }
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

    .my-wrapper {
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
  .section2 {
    padding: 44px !important;
  }
}
</style>
