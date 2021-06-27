<template>
  <div class="">
    <Header v-on:togal-menu="$emit('togal-menu')" :scrollValue="scrollValue" />
    <div class="container mt-5">
      <b-card header="Tips & Reviews" class="shadow border-0">
        <h4>How you evalvate our performance?</h4>
        <br />
        <b-form-group>
          <star-rating
            v-model="form.rating"
            :star-size="30"
            @rating-selected="setRating"
          />
        </b-form-group>

        <b-form-group>
          <b-form-checkbox v-model="isTips">
            Are you willing to give some tips?
          </b-form-checkbox>
        </b-form-group>

        <b-form-group v-if="isTips">
          <b-input-group prepend="$">
            <b-form-input
              v-model="form.tips"
              :required="isTips"
              placeholder="Amount"
              type="number"
              :min="1"
            ></b-form-input>
          </b-input-group>
        </b-form-group>

        <div class="text-right mt-3">
          <b-spinner variant="primary" v-if="isSubmitting" />
          <b-button v-else @click="submit" variant="primary">Submit</b-button>
        </div>
      </b-card>
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
  height: calc(100vh - 55px);
}
</style>
