<template>
  <div class="container">
    <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue" />
    <div class="content">
      <md-card>
        <md-card-header>
          <span class="md-title">Tips & Review</span>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <p>How you evalvate our performance?</p>
          <star-rating
            v-model="form.rating"
            :star-size="30"
            @rating-selected="setRating"
          />
          <md-switch v-model="isTips">Are you willing to give some tips?</md-switch>
          <md-field v-if="isTips">
            <label>Amount($)</label>
            <md-input v-model="form.tips" :required="isTips"></md-input>
          </md-field>
        </md-card-content>

        <md-card-actions>
          <Spinner v-if="isSubmitting" />
          <md-button v-else @click="submit" class="md-primary">Submit</md-button>
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
import Spinner from "../../../shared/Spinner";
import Footer from "../../../shared/Footer";
import Header from "../../../shared/Header";
import axios from "axios";
export default {
  props: ["scrollValue"],
  data: () => ({
    isTips: null,
    isSubmitting: false,
    form: {
      ratting: 0,
      tips: null,
    },
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    setRating(e) {
      console.log("x", e);
      this.form.ratting = e;
    },
    submit() {
      this.isSubmitting = true;
      if (this.form.rating > 0) {
        axios
          .put("shipper/rating/" + this.$route.params.id, this.form)
          .then((res) => {
            this.isSubmitting = false;
            console.log(res.data);
            this.snackbar.message = res.data.message;
            this.snackbar.statusCode = 200;
            this.snackbar.show = true;
            setTimeout(() => {
              this.$router.push("/");
            }, 3000);
          })
          .catch((err) => console.log(err));
      } else {
        this.isSubmitting = false;
        this.snackbar.message = "Please give some stars";
        this.snackbar.statusCode = 200;
        this.snackbar.show = true;
      }
    },
  },
  components: {
    Snackbar,
    Spinner,
    Header,
    Footer,
    StarRating,
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
      text-align: left;
    }
  }
}
</style>
