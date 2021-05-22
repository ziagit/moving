<template>
  <div class="home-content">
    <div
      class="section0"
      v-bind:style="{ 'background-image': 'url(/images/uploads/' + bgImage + '.svg)' }"
    >
      <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue" />
      <div class="content">
        <div>
          <div class="md-title" style="font-size: 26px">Hey there,</div>
          <div class="break"></div>
          <div class="md-display-1">Let's get you moved.</div>
          <!-- <div class="md-subheading">The way you book your moving tickets.</div> -->
          <div class="break"></div>
          <div class="break"></div>
          <div class="break"></div>

          <div class="md-title">
            Whether you’re moving your sofa or bed, your apartment or office.
          </div>
          <div class="md-title">
            <b>Book your Movers just like you book your ride.</b>
          </div>
          <div class="break"></div>
          <div class="break"></div>
          <div class="actions">
            <GoogleAddress2 />
          </div>
        </div>
      </div>
    </div>
    <div class="wrapper">
      <div class="section2">
        <div class="heading">
          <div class="md-display-1">Safe and hassle-free Moving</div>
          <div class="break"></div>
          <div class="md-body-1">Get your things moved with peace of mind.</div>
        </div>
        <div class="rows">
          <div class="row">
            <img :src="'/images/uploads/transparent.svg'" width="35" alt="" />
            <div>
              <div class="md-title">Transparent</div>
              <div class="md-body-1">
                Upfront pricing with no moving day surprise or hidden fees. know your
                moving cost before you book.
              </div>
            </div>
          </div>
          <div class="row with-shadow">
            <img :src="'/images/uploads/nosignup.svg'" width="35" alt="" />
            <div>
              <div class="md-title">No Sign up</div>
              <div class="md-body-1">
                Get free quotes and book your moving in a few taps. No sign up or
                membership required.
              </div>
            </div>
          </div>
          <div class="row">
            <img :src="'/images/uploads/inssured.svg'" width="35" alt="" />
            <div>
              <div class="md-title">Insured</div>
              <div class="md-body-1">
                From the moment your stuffs are in our hands they are protected by our
                insurance policy.
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="section3"
        v-bind:style="{
          'background-image': 'url(/images/uploads/section3.svg)',
        }"
      >
        <div class="text">
          <div class="md-display-1">How it works</div>
          <div class="break"></div>
          <div><b>TingsApp works just the way ride-hailing apps work.</b></div>
          <div class="break"></div>
          <div class="md-body-1">
            Your guaranteed price is based on the size of moving, number of movers, size
            of vehicle and the distance from source to destination. All of our movers are
            verified, professional and licensed.
          </div>
        </div>
        <div class="steps">
          <div class="head"></div>
          <ul>
            <li>
              <div class="avatar">
                <img :src="'/images/uploads/track-order.svg'" alt="People" />
              </div>
              <div class="text">
                <div class="md-title">Request in the app</div>
                <div class="details">
                  Let us know your moving needs and get an upfront price.
                </div>
              </div>
            </li>

            <md-divider></md-divider>
            <li>
              <div class="avatar">
                <img :src="'/images/uploads/select-carrier.svg'" alt="People" />
              </div>
              <div class="text">
                <div class="md-title">Get matched with movers</div>
                <div class="details">
                  Get connected with your movers in minutes. You can message them in app
                  and track your stuff as moving happens.
                </div>
              </div>
            </li>
            <md-divider></md-divider>
            <li>
              <div class="avatar">
                <img :src="'/images/uploads/item-list.svg'" alt="People" />
              </div>
              <div class="text">
                <div class="md-title">Rate & tip</div>
                <div class="details">
                  We place your stuff right where you want them. Tell us about your
                  experience and tip your movers for a job well done in app.
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="section4">
        <div class="row img">
          <img :src="'/images/uploads/callendar.svg'" alt="" />
        </div>
        <div class="row txt">
          <div class="md-display-1">In advance or on-demand</div>
          <div class="break"></div>
          <div class="md-body-1">
            We know moving is stressful. To make sure the availability and on-time
            service, schedule your moving day ahead of time. Relax, we will notify you
            when its time. Or request ondemand for last minute moving.
          </div>
          <md-button class="custom-button" to="/order">Get Quote</md-button>
        </div>
      </div>
      <div class="section5">
        <div class="row txt">
          <div class="md-display-1">Here is what our customers say.</div>
          <div class="break"></div>
          <div class="md-body-1">
            <div class="customer-comment">
              "This was my first time using TingsApp, simple and impressive. The way
              everything worked from booking to up-front pricing and professional movers I
              would say my satisfaction level is to the roof compare to my previous moving
              experiences and yet cheaper. Highly recommended.
              <div class="break"></div>
              <div class="customer"><span>Tim F. Vancouver</span></div>
            </div>
          </div>
          <md-button class="custom-button" to="/rating">Leave a Review</md-button>
        </div>
        <div class="row img">
          <img :src="'/images/uploads/home-graph.svg'" alt="" />
        </div>
      </div>
      <div class="section1">
        <div class="row">
          <div class="md-display-1">500+</div>
          <div class="md-subheading">App Download In 2021</div>
          <div>
            <router-link to="#"
              >Download Now<md-icon>keyboard_arrow_right</md-icon>
            </router-link>
          </div>
        </div>
        <div class="row row2">
          <div class="md-display-1">1200+</div>
          <div class="md-subheading">Moving booked In 2021</div>
          <div>
            <router-link to="#"
              >Book Now <md-icon>keyboard_arrow_right</md-icon>
            </router-link>
          </div>
        </div>
        <div class="row row3">
          <div class="md-display-1">
            Trusted by over 125k+ customers in the US and Canada
          </div>
        </div>
        <div class="row"></div>
      </div>
    </div>

    <Footer />
  </div>
</template>

<script>
import Footer from "../../shared/Footer";
import GoogleAddress2 from "../../shared/GoogleAddress2.vue";
import Header from "../../shared/Header";
import MovingFrom from "../order/MovingFrom.vue";
import MovingTo from "../order/MovingTo.vue";
import localData from "../services/localData";

export default {
  name: "HomeContent",
  props: ["scrollValue"],
  data: () => ({
    bgImage: "moving",
  }),

  methods: {
    changeImage(img) {
      this.bgImage = img;
    },
    menuTogal() {
      this.$emit("menu-togal");
    },
  },

  components: {
    Header,
    Footer,
    MovingFrom,
    MovingTo,
    GoogleAddress2,
  },
};
</script>

<style lang="scss" scoped>
.home-content {
  background: #fff;
  .section0 {
    text-align: left;
    height: calc(100vh - 48px);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center center;
    box-shadow: none !important;

    .content {
      text-align: left;
      margin: 100px 0 12px 106px;
      max-width: 667px;

      .md-display-1 {
        line-height: 61px;
        font-size: 64px;
        font-weight: 900;
        color: #000;
        letter-spacing: -2px;
      }
      .md-subheading {
        margin-top: 0;
        color: #848484;
        font-size: 18px;
      }
      .md-title {
        font-size: 17px;
        font-weight: 400;
        line-height: 1.5;
      }
      .actions {
        width: 100%;
      }
    }
  }

  .wrapper {
    background: #fff;
    max-width: 1200px;
    margin: auto;
    padding-bottom: 126px;

    .section1 {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      padding: 46px 100px;

      .row {
        flex: 25%;

        .md-display-1 {
          color: #ffa500;
          font-weight: 500;
        }

        .md-subheading {
          color: #000;
        }
      }

      .row2 {
        .md-display-1 {
          color: #f58720;
        }
      }

      .row3 {
        .md-display-1 {
          color: #000;
          font-size: 22px;
          line-height: 28px;
        }
      }
    }

    .section2 {
      padding: 46px 100px;

      .heading {
        padding: 20px 20px 20px 0;

        .md-display-1 {
          color: #000;
          line-height: 38px;
          font-weight: 500;
        }

        .md-body-1 {
          font-size: 16px;
          line-height: 24px;
        }
      }

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

          .md-title {
            line-height: 52px;
            font-weight: 600;
            line-height: 44px;
          }
        }

        .with-shadow {
          background: #fff;
          box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
          border: none;
        }
      }
    }

    .section3 {
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center center;
      padding: 76px;
      margin: 30px 30px 60px 30px;
      min-height: 500px;
      max-width: 80%;
      position: relative;

      .text {
        .md-display-1 {
          line-height: 38px;
          max-width: 367px;
          color: #000;
          font-weight: 500;
        }

        .md-body-1 {
          max-width: 380px;
          font-size: 14px;
          line-height: 20px;
        }
      }

      .steps {
        max-width: 436px;
        background: #fff;
        position: absolute;
        right: -100px;
        bottom: -50px;
        box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
        .head {
          min-height: 9px;
          width: 100%;
          background: #f17947;
        }
        ul {
          padding: 20px 36px;
          margin: 0;

          li {
            display: flex;
            justify-content: space-between;

            .avatar {
              display: flex;
              flex: 24%;
              padding: 16px;
            }
            .text {
              flex: 75%;
              padding: 10px;

              .md-title {
                font-weight: 600;
                line-height: 34px;
                font-size: 16px;
              }
              .details {
                font-size: 12px;
                color: #6c6b6b;
              }
            }
          }
          .md-divider {
            height: 0.1px !important;
          }
        }
      }
    }
    .section4,
    .section5 {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      padding: 46px 100px;

      .row {
        flex: 50%;

        .md-display-1 {
          font-weight: 500;
          font-size: 30px;
          line-height: 38px;
          color: #000;
        }

        .md-body-1 {
          margin: 3px 0 26px 0;
          font-size: 14px;
          line-height: 24px;
        }
        img {
          padding: 15px;
        }
      }
      .customer-comment {
        border-left: 8px solid #fffbf3;
        padding: 5px;
        color: #6f6b6b;
        font-style: italic;
        margin: 10px;
        .customer {
          text-align: right;
        }
      }
    }
    .section4 {
      .img {
        padding: 30px;
        img {
          box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
        }
      }
      .txt {
        padding: 30px 0 0 30px;
      }
    }
  }
}
@media only screen and (max-width: 992px) {
  .section0 {
    .md-display-1 {
      font-size: 40px !important;
    }
  }
}
@media only screen and (max-width: 769px) {
  .section3 {
    .steps {
      max-width: 360px !important;

      ul {
        li {
          padding: 12px !important;
        }
      }
    }
  }
}

@media only screen and (max-width: 600px) {
  .section0 {
    .content {
      margin: 0 !important;
      padding: 85px 24px !important;
      //text-align: center !important;
      .md-display-1 {
        font-size: 39px !important;
        line-height: 48px !important;
      }
      .md-subheading {
        font-size: 14px !important;
      }
      .md-title {
        font-size: 17px !important;
      }
      .actions {
      }
    }
  }

  .section1 {
    display: none !important;
  }

  .section2 {
    padding: 20px !important;
    .row {
      flex: 100% !important;
    }
  }

  .section3 {
    margin: 0 !important;
    max-width: 100% !important;
    padding: 20px !important;

    .steps {
      position: relative !important;
      right: 0 !important;
      bottom: 0 !important;
      margin-top: 44px !important;
      .avatar {
        padding: 3px !important;
      }
    }
  }

  .section4 {
    flex-direction: column !important;
    padding: 20px !important;
    .img {
      margin-bottom: 164px !important;
    }
    .txt {
      padding: 0 !important;
      .md-display-1 {
        margin: 0 !important;
      }
      .md-body-1 {
        margin: 0 0 20px 0 !important;
      }
    }
  }
  .section5 {
    flex-direction: column !important;
    padding: 20px !important;
    .img {
      order: 1;
      margin-bottom: 196px !important;
    }
    .txt {
      order: 2;
      .md-body-1 {
        margin: 0 0 20px 0 !important;
      }
    }
  }
  .section1,
  .section2,
  .section3,
  .section4,
  .section5 {
    .md-display-1 {
      line-height: 32px !important;
      font-size: 24px !important;
      font-weight: 500 !important;
      max-width: 100% !important;
    }
    .md-body-1 {
      max-width: 100% !important;
    }
  }
}
</style>
