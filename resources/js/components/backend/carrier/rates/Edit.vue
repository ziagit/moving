<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-field>
        <label>Price/hr</label>
        <md-input v-model="form.price"></md-input>
      </md-field>
      <md-button type="submit" class="md-primary md-small-fab">Done</md-button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  name: "EditRate",
  props: ["rate"],
  data: () => ({
    form: {
      vehicle: null,
      number: null,
      price: null,
    },
  }),
  watch: {},
  created() {
    this.init();
  },
  computed: {
    ...mapGetters({
      temp: "shared/temp",
    }),
  },
  methods: {
    update() {
      axios
        .put("admin/rates/" + this.rate.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    getCountries() {
      axios
        .get("countries")
        .then((res) => {
          console.log("counteris: ", res.data);
          this.countries = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    init() {
      this.form.price = this.rate.price;
    },
  },
};
</script>

<style lang="scss" scoped>
.md-button {
  float: right;
}
</style>
