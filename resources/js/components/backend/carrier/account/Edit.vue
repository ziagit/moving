<template>
  <b-card header="Edit Account" class="shadow text-left border-0">
    <form @submit.prevent="submit">
      <b-button variant="light" @click="$emit('close-it')" class="add-btn">
        <b-icon icon="x"></b-icon>
      </b-button>
      <div>
        <b-form-group>
          <b-form-input
            type="text"
            v-model="form.name"
            required
            ref="focusable"
            placeholder="Name"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-input
            type="text"
            v-model="form.email"
            required
            placeholder="Email"
          ></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-form-checkbox id="checkbox-1" v-model="passwordTogal" name="checkbox-1">
            Change my password
          </b-form-checkbox>
        </b-form-group>
        <b-form-group v-if="passwordTogal">
          <label for="">New Password</label>
          <b-form-input
            type="password"
            v-model="form.password"
            :required="passwordTogal"
            placeholder="Password"
          ></b-form-input>
        </b-form-group>
        <b-form-group v-if="passwordTogal">
          <b-form-input
            type="password"
            v-model="form.password_confirmation"
            :required="passwordTogal"
            placeholder="Confirm password"
          ></b-form-input>
        </b-form-group>
      </div>
      <div class="text-right mt-3">
        <b-button type="submit" variant="primary"> Update </b-button>
      </div>
    </form>
  </b-card>
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
        password: null,
        password_confirmation: null,
      },
    };
  },
  methods: {
    submit() {
      axios
        .put("admin/users/" + this.user.id, this.form)
        .then((res) => {
          this.$emit("close-dialog");
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
