<template>
  <div>
    <md-card>
      <form @submit.prevent="update">
        <md-card-header>
          <span class="md-title">Edit User</span>
          <md-button @click="$emit('cancel')" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
            <md-tooltip>Cancel</md-tooltip>
          </md-button>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <md-field class="">
            <label>Name</label>
            <md-input v-model="form.name" required></md-input>
          </md-field>
          <md-field class="">
            <label>Email</label>
            <md-input v-model="form.email" required></md-input>
          </md-field>
          <md-field class="">
            <label>Phone</label>
            <md-input v-model="form.phone" required></md-input>
          </md-field>
          <md-switch v-model="passwordTogal">Change my password</md-switch>
          <md-field class="" v-if="passwordTogal">
            <label>New nassword</label>
            <md-input
              type="password"
              v-model="form.password"
              :required="passwordTogal"
            ></md-input>
          </md-field>
          <md-field class="" v-if="passwordTogal">
            <label>Password confirmation</label>
            <md-input
              type="password"
              v-model="form.password_confirmation"
              :required="passwordTogal"
            ></md-input>
          </md-field>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">Update</md-button>
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
        name: this.user.name,
        email: this.user.email,
        phone: this.user.phone,
        password: null,
        password_confirmation: null,
      },
    };
  },
  methods: {
    update() {
      axios
        .put("admin/users/" + this.user.id, this.form)
        .then((res) => {
          this.$emit("refresh");
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
