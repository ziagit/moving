<template>
  <div>
    <md-card>
      <form @submit.prevent="submit">
        <md-card-header>
          <span class="md-title">Edit Account v</span>
          <md-button @click="$emit('close-it')" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
            <md-tooltip>Cancel</md-tooltip>
          </md-button>
        </md-card-header>
        <md-card-content>
          <md-field>
            <label for="">Email</label>
            <md-input
              type="text"
              v-model="form.email"
              required
              ref="focusable"
            ></md-input>
          </md-field>
          <md-switch v-model="passwordTogal">Change my password</md-switch>
          <md-field v-if="passwordTogal">
            <label for="">New Password</label>
            <md-input
              type="password"
              v-model="form.password"
              :required="passwordTogal"
              ref="focusable"
            ></md-input>
          </md-field>
          <md-field v-if="passwordTogal">
            <label for="">Confirm password</label>
            <md-input
              type="password"
              v-model="form.password_confirmation"
              :required="passwordTogal"
              ref="focusable"
            ></md-input>
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary"> Update </md-button>
        </md-card-actions>
      </form>
    </md-card>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["user"],
  data() {
    return {
      passwordTogal: false,
      form: {
        email: this.user.email,
        password: null,
        password_confirmation: null,
      },
    };
  },
  methods: {
    submit() {
      axios
        .post("admin/users", this.form)
        .then((res) => {
          //this.$emit("refresh");
          console.log("updated: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
  },
};
</script>
<style scoped>
.add-btn {
  position: absolute;
  top: 1px;
  right: 1px;
}
</style>
