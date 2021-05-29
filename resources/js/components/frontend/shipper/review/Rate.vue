<template>
  <div class="rating">
    <star-rating v-model="rating" :star-size="30" @rating-selected="setRating" />
  </div>
</template>
<script>
import StarRating from "vue-star-rating";
import axios from "axios";
export default {
  props: ["carrier"],
  data: () => ({
    rating: 0,
    vtd: [],
  }),
  methods: {
    setRating(e) {
      this.rating = e;
      this.submit();
    },
    submit() {
      if (this.rating > 0 && !this.vtd.includes(this.carrier)) {
        axios
          .put("rating/" + this.carrier, { rate: this.rating })
          .then((res) => {
            this.vtd.push(this.carrier);
            localStorage.setItem("vtd", JSON.stringify(this.vtd));
            this.$emit("rated", { message: res.data, id: 0 });
            console.log("voted", sessionStorage.getItem("vtd"));
          })
          .catch((err) => console.log(err));
      } else {
        this.$emit("rated", {
          message: "You already rated!",
          id: this.carrier,
        });
      }
    },
  },
  created() {
    if (localStorage.getItem("vtd")) {
      this.vtd = JSON.parse(localStorage.getItem("vtd"));
    }
  },
  components: {
    StarRating,
  },
};
</script>
<style scoped>
.rating {
  text-align: center;
  padding: 30px;
}
</style>
