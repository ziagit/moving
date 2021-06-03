<template>
  <div class="account">
    <md-card>
      <md-card-header>
        <div class="md-title">Change Logo</div>
        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <form @submit.prevent="update">
          <Spinner v-if="isSubmitting" />
          <md-field v-else>
            <label>Select file</label>
            <md-file @change="onChange" />
          </md-field>
          <md-button type="submit" class="md-primary">Update</md-button>
        </form>
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import Spinner from "../../../shared/Spinner";
export default {
  name: "EditCarrierAccount",
  components: {
    Spinner,
  },
  data: () => ({
    isSubmitting: false,
    avatar: "",
  }),
  methods: {
    onChange(e) {
      this.avatar = e.target.files[0];
      console.log(this.avatar);
    },
    update() {
      this.isSubmitting = true;
      console.log("ava", this.avatar);
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
  .md-card {
    text-align: left;
    .md-card-content {
      padding: 20px;
    }
    .md-card-actions {
      display: flex;
      justify-content: flex-start;
    }
  }
}

.close-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
