<template>
  <md-card>
    <form @submit.prevent="submitAccount">
      <md-card-header>
        <span class="md-title">Edit Account</span>
        <md-button @click="$emit('close-child')" class="md-icon-button add-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
      </md-card-header>
      <md-card-content>
        <md-field>
          <label for="">Email</label>
          <md-input type="text" v-model="form.email" required ref="focusable"></md-input>
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
</template>

<script>
import axios from "axios";
export default {
  name: "CarrierDetails",
  props: ["user"],
  data: () => ({
    passwordTogal: false,
    form: {
      email: null,
      password: null,
      password_confirmation: null,
    },
  }),

  methods: {
    submitAccount() {
      axios
        .put("carrier/account/" + this.user.id, this.form)
        .then((res) => {
          this.$emit("close-child");
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
  },

  created() {
    this.form.email = this.user.email;
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .md-card-content {
    padding: 20px;
    .row {
      display: flex;
      > :first-child {
        width: 200px;
      }
    }
  }
  .md-card-actions {
    display: flex;
    justify-content: flex-start;
  }
}
.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
