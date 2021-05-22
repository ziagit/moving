<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue" />
    <div class="content">
      <span class="md-display-1">Rview </span>
      <md-card>
        <md-card-header>
          <md-avatar>
            <img src="/assets/examples/avatar.png" alt="Avatar" />
          </md-avatar>

          <div class="md-title">{{ carrier.first_name }}</div>
          <div class="md-subhead">{{ carrier.last_name }}</div>
        </md-card-header>

        <md-card-content>
          <div class="reviews">
            {{ carrier.detail }}
            <ul>
              <li v-for="review in carrier.reviews" :key="review.id">
                <div>{{ review.name }}</div>
                <div>{{ review.message }}</div>
              </li>
            </ul>
          </div>
        </md-card-content>

        <md-card-actions>
          <md-button>Action</md-button>
          <md-button>Action</md-button>
        </md-card-actions>
      </md-card>
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
    carrier: "",
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  created() {
    this.getCarriers();
  },
  methods: {
    getCarriers() {
      axios
        .get("review/" + this.$route.params.id)
        .then((res) => {
          this.carrier = res.data;
          console.log("carrier here: ", res.data);
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
    .md-card {
      .md-card-header {
        .md-title,
        .md-subhead {
          text-align: left !important;
        }
      }
      .md-card-content,
      .reviews {
        text-align: left;
      }
    }
  }
}
</style>
