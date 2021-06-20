<template>
  <div class="container mt-5">
    <div v-if="editTogal">
      <b-card header="Change Logo" class="border-0 shadow">
        <b-button @click="editTogal = false" variant="light" class="close-btn">
          <b-icon icon="backspace"></b-icon>
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
    <div v-else>
      <b-card v-if="account" header="Logo" class="border-0 shadow">
        <div class="mb-3">
          <img :src="'/images/pub/' + account.avatar" width="80" alt="" />
        </div>
        <b-button @click="edit()" variant="primary"> Change </b-button>
      </b-card>
    </div>
    <div class="mt-3" v-if="account">
      <Edit v-if="accountTogal" :user="account" v-on:close-child="accountTogal = false" />
      <b-card v-else header="Account" class="border-0 shadow text-left mb-4">
        <div class="row">
          <span class="col-3 text-left">Email:</span>
          <span class="col-9 text-left">{{ account.email }}</span>
        </div>
        <div class="row">
          <span class="col-3 text-left">Password:</span>
          <span class="col-9 text-left">********</span>
        </div>
        <div class="text-right mt-3">
          <b-button @click="accountTogal = true" variant="primary"> Edit </b-button>
        </div>
      </b-card>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import Edit from "./Edit";
export default {
  name: "Account",
  components: {
    Edit,
  },
  data: () => ({
    account: null,
    editTogal: false,
    accountTogal: false,
    isSubmitting: false,
    avatar: null,
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/accounts")
        .then((res) => {
          this.account = res.data;
          console.log("carrier acoutn: ", this.account);
        })
        .catch((err) => console.log(err));
    },
    edit() {
      this.editTogal = true;
      //this.$router.push("edit/" + this.account.id);
    },
    onChange(e) {
      this.avatar = e.target.files[0];
    },
    update() {
      this.isSubmitting = true;
      let fd = new FormData();
      fd.append("avatar", this.avatar);
      axios
        .post("admin/accounts/avatar", fd)
        .then((res) => {
          console.log("res: ", res.data);
          this.get();
          this.editTogal = false;
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style lang="scss" scoped>
.container {
  height: calc(100vh - 50px);
  .close-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
