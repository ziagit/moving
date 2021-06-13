<template>
  <div class="shipper-account">
    <md-card>
      <form @submit.prevent="update">
        <md-card-header>
          <span class="md-title">Change Avatar</span>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <Spinner v-if="isSubmitting" />
          <md-field v-else>
            <label>Select file</label>
            <md-file @change="onChange" />
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">
            Update
            <md-tooltip>Update avatar</md-tooltip>
          </md-button>
        </md-card-actions>
      </form>
    </md-card>
  </div>
</template>
<script>
import Spinner from "../../../shared/Spinner";
import axios from "axios";
export default {
  name: "EditShipperAccount",
  components: {
    Spinner,
  },
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
