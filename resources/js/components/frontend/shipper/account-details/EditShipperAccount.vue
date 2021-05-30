<template>
  <div class="shipper-account">
    <md-card>
      <md-card-header>
        <span class="md-title">Change Avatar</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <form @submit.prevent="update">
          <Spinner v-if="isSubmitting" />
          <md-field v-else>
            <label>Select file</label>
            <md-file @change="onChange" />
          </md-field>
        </form>
      </md-card-content>
      <md-card-actions>
        <md-button type="submit" class="md-primary">
          Update
          <md-tooltip>Update avatar</md-tooltip>
        </md-button>
      </md-card-actions>
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
      this.isSubmitting = true;
      let fd = new FormData();
      fd.append("avatar", this.avatar);
      fd.append("_method", "put");
      axios
        .post("shipper/account/" + this.$route.params.id, fd)
        .then((res) => {
          this.account = res.data;
          this.$router.back();
          console.log("res: ", res.data);
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
