<template>
  <div class="account">
    <b-card header="Change Logo" class="border-0 shadow">
      <b-button @click="$router.back()" variant="light" class="close-btn">
        <b-icon icon="x"></b-icon>
      </b-button>
      <form @submit.prevent="update">
        <b-spinner variant="primary" v-if="isSubmitting" />
        <b-form-file
          v-else
          @change="onChange"
          v-model="avatar"
          :state="Boolean(avatar)"
          placeholder="Choose a file or drop it here..."
          drop-placeholder="Drop file here..."
        ></b-form-file>

        <div class="text-right mt-3">
          <b-button type="submit" variant="primary">Update</b-button>
        </div>
      </form>
    </b-card>
  </div>
</template>
<script>
export default {
  name: "EditCarrierAccount",
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
      this.isSubmitting = true;
      let fd = new FormData();
      fd.append("avatar", this.avatar);
      axios
        .post("carrier/change-avatar/" + this.$route.params.id, fd)
        .then((res) => {
          console.log("res: ", res.data);
          this.account = res.data;
          this.$router.back();
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style lang="scss" scoped>
.account {
  text-align: left;
}

.close-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
