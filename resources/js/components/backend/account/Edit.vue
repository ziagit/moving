<template>
  <b-card header="Edit Account" class="text-left border-0 shadow">
    <form @submit.prevent="submit" header="Edit Account">
      <b-button @click="$emit('close-child')" class="add-btn" variant="ligth">
        <b-icon icon="backspace"></b-icon>
      </b-button>
      <b-form-input
        type="text"
        v-model="form.email"
        required
        ref="focusable"
      ></b-form-input>
      <b-form-checkbox class="mt-3 mb-3" v-model="passwordTogal" switch
        >Change my password</b-form-checkbox
      >
      <b-form-input
        v-if="passwordTogal"
        type="password"
        v-model="form.password"
        :required="passwordTogal"
        ref="focusable"
        placeholder="Password"
        class="mb-3"
      >
      </b-form-input>
      <b-form-input
        v-if="passwordTogal"
        placeholder="Confirm password"
        type="password"
        v-model="form.password_confirmation"
        :required="passwordTogal"
        class="mb-3"
      >
      </b-form-input>
      <div class="text-right">
        <b-button type="submit" variant="primary"> Update </b-button>
      </div>
    </form>
  </b-card>
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
    submit() {
      axios
        .put("admin/accounts/" + this.user.id, this.form)
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
