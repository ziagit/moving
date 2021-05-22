<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue" />
    <div class="content">
      <span class="md-display-1">Rate our carriers</span>

      <md-list class="md-triple-line carriers">
        <md-list-item v-for="carrier in carriers" :key="carrier.id">
          <md-avatar>
            <md-icon v-if="carrier.logo === 'undefined'">sentiment_satisfied_alt</md-icon>
            <img v-else :src="'/images/uploads/' + carrier.logo" alt="People" />
          </md-avatar>
          <div class="md-list-item-text">
            <span v-if="carrier.company !== 'null'">{{ carrier.company }}</span>
            <span v-else>{{ carrier.last_name }}</span>
            <span>{{ carrier.first_name }}</span>
            <p>
              <md-menu md-direction="top-start" :md-active.sync="carrier.togal">
                <span class="carrier-info" md-menu-trigger>Read</span> about this carrier
                <md-menu-content>
                  <CarrierInfo
                    :lastName="carrier.last_name"
                    :company="carrier.company"
                    :detail="carrier.detail"
                  />
                </md-menu-content>
              </md-menu>
            </p>
            <div class="rating">
              <star-rating
                v-model="carrier.rates"
                :star-size="15"
                :read-only="true"
                :show-rating="false"
              />
            </div>
          </div>
          <div class="list-action">
            <md-menu md-direction="top-start" :md-active.sync="carrier.togal">
              <md-button md-menu-trigger class="md-primary">Rate</md-button>
              <md-menu-content>
                <Rate :carrier="carrier.id" v-on:rated="rated" />
              </md-menu-content>
            </md-menu>
          </div>
        </md-list-item>
      </md-list>
    </div>
    <Footer />
    <Snackbar :data="snackbar" />
  </div>
</template>
<script>
import StarRating from "vue-star-rating";
import Snackbar from "../../../shared/Snackbar";
import CarrierInfo from "../../order/menu/CarrierInfo";
import Rate from "./Rate";
import Footer from "../../../shared/Footer";
import Header from "../../../shared/Header";
import axios from "axios";
export default {
  props: ["scrollValue"],
  data: () => ({
    rating: 0,
    carriers: "",
    closeOnClick: true,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  watch: {
    carriers(data) {
      for (let i = 0; i < data.length; i++) {
        data[i]["togal"] = false;
      }
    },
  },
  created() {
    this.getCarriers();
  },
  methods: {
    getCarriers() {
      axios
        .get("rating")
        .then((res) => {
          this.carriers = res.data;
          console.log("carriers: ", res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    rated(data) {
      this.snackbar.show = true;
      this.snackbar.message = data.message;
      this.snackbar.statusCode = 200;
      if (!JSON.parse(localStorage.getItem("vtd")).includes(data.id)) {
        this.getCarriers();
      }
    },
  },
  components: {
    Snackbar,
    StarRating,
    CarrierInfo,
    Rate,
    Header,
    Footer,
  },
};
</script>
<style scoped lang="scss">
.container {
  .content {
    text-align: center;
    height: calc(100vh - 55px);
    padding: 30px;
    max-width: 600px;
    margin: auto;
    ul {
      background: none;

      li {
        .carrier-info {
          color: #448aff;
        }

        .carrier-info:hover {
          cursor: pointer;
        }
        box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
        margin-bottom: 5px;
        border-radius: 3px;
        background: #fff;

        .button {
          border-radius: 7px;
        }
        .md-list-item-content {
          min-height: 165px !important;
        }
        .rating {
          max-width: 75px;
        }
      }
    }
  }
}
</style>
