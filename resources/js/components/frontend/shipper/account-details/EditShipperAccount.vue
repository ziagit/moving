<template>
  <div class="edit-account">
    <md-card class="no-shadow-bordered">
      <md-card-header>
        <div class="md-title">Edit Account</div>
        <md-button @click="$router.back()" class="md-icon-button close-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
      </md-card-header>
      <md-card-content>
        <div class="edit-form">
          <form @submit.prevent="update">
            <md-field>
              <label>Name</label>
              <md-input v-model="form.name" required></md-input>
            </md-field>
            <md-field>
              <label>Email</label>
              <md-input v-model="form.email" required></md-input>
            </md-field>
            <div>
              <md-switch v-model="passwordTogal">Change my password</md-switch>
            </div>
            <div v-if="passwordTogal">
              <md-field>
                <label>New password</label>
                <md-input
                  v-model="form.password"
                  :required="passwordTogal"
                  type="password"
                ></md-input>
              </md-field>
              <md-field>
                <label>Confirm password</label>
                <md-input
                  v-model="form.confirmPassword"
                  :required="passwordTogal"
                  type="password"
                ></md-input>
              </md-field>
            </div>

            <md-button type="submit">Done</md-button>
          </form>
        </div>
      </md-card-content>
    </md-card>
    <md-snackbar
      class="required-feild-error"
      :md-position="snackbar.position"
      :md-duration="snackbar.isInfinity ? Infinity : snackbar.duration"
      :md-active.sync="snackbar.show"
      md-persistent
    >
      <span>{{ snackbar.message }}</span>
      <span style="color: red">Status: {{ snackbar.statusCode }}</span>
    </md-snackbar>
  </div>
</template>
<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  name: "ShipperGeneralInfo",
  data: () => ({
    form: {
      name: null,
      email: null,
      password: null,
      confirmPassword: null,
    },
    passwordTogal: false,
    snackbar: {
      show: false,
      position: "center",
      duration: 5000,
      isInfinity: false,
      message: null,
      statusCode: null,
    },
  }),
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    update() {
      axios
        .put("shipper/account/" + this.user.id, this.form)
        .then((res) => {
          this.$router.push("/shipper/account");
          console.log("response: ", res.data);
        })
        .catch((error) => {
          this.snackbar.show = true;
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
        });
    },
  },
  created() {
    this.form.name = this.user.name;
    this.form.email = this.user.email;
  },
};
</script>
<style lang="scss" scoped>
.md-card {
  text-align: center;
  .edit-form {
    max-width: 600px;
    margin: auto;
  }
  .close-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
