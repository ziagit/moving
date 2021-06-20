<template>
  <b-card header="Change Avatar" class="border-0 shadow text-left">
    <form @submit.prevent="update">
      <b-spinner variant="primary" v-if="isSubmitting" />
      <b-form-group v-else>
        <b-form-file @change="onChange" />
      </b-form-group>
      <div class="mt-3 text-right">
        <b-button type="submit" variant="primary"> Update </b-button>
      </div>
    </form>
  </b-card>
</template>
<script>
import axios from "axios";
export default {
  name: "EditShipperAccount",
  components: {},
  data: () => ({
    isSubmitting: false,
    avatar: null,
  }),
  methods: {
    onChange(e) {
      this.avatar = e.target.files[0];
    },
    update() {
      console.log("hier");
      this.isSubmitting = true;
      let fd = new FormData();
      fd.append("avatar", this.avatar);
      axios
        .post("shipper/change-avatar/" + this.$route.params.id, fd)
        .then((res) => {
          this.account = res.data;
          console.log("res: ", res.data);
          this.$router.back();
        })
        .catch((err) => console.log(err));
    },
  },
  created() {},
};
</script>
<style lang="scss" scoped>
.shipper-account {
  .md-card {
    text-align: left;
    padding: 20px;
    .md-card-actions {
      display: flex;
      justify-content: flex-start;
    }
  }
}
</style>
