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
          <b-spinner variant="primary" v-if="isSubmitting" />
          <md-button v-else @click="submit" class="md-primary">Submit</md-button>
        </md-card-actions>
      </md-card>
    </div>
    <Footer />
    <Toaster ref="toaster" />
  </div>
</template>
<script>
import StarRating from "vue-star-rating";
import Toaster from "../../../shared/Toaster";
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
            this.$refs.toaster.show(
              "success",
              "b-toaster-top-right",
              "Success",
              res.data.message
            );
            setTimeout(() => {
              this.$router.push("/");
            }, 3000);
          })
          .catch((err) => console.log(err));
      } else {
        this.isSubmitting = false;

        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-right",
          "Warning",
          "Please give some stars"
        );
      }
    },
  },
  components: {
    Toaster,
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
