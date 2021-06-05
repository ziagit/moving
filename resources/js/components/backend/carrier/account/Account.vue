<template>
  <div>
    <md-dialog-confirm
      :md-active.sync="lockTogal"
      md-title="Confirm to change account status"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirmLock()"
      @md-cancel="cancel"
    />
    <Edit
      v-if="editTogal"
      v-on:close-it="refresh"
      :user="details"
      v-on:refresh="refresh"
    />
    <md-card v-else>
      <md-card-header>
        <span class="md-title">Account Details</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content v-if="details">
        <div class="row">
          <span>Email: </span>
          <span>{{ details.email }}</span>
        </div>
        <div class="row">
          <span>Password: </span>
          <span>********</span>
        </div>
        <div class="row">
          <span>Status: </span>
          <span :class="[details.status == 'Active' ? 'unlocked' : 'locked']">{{
            details.status
          }}</span>
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button class="md-primary" @click="editTogal = true">Edit</md-button>
        <md-button class="md-primary" @click="lockTogal = true">Suspend</md-button>
      </md-card-actions>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
import Edit from "./Edit";
export default {
  name: "User",
  props: ["user"],
  components: {
    Edit,
  },
  data: () => ({
    editTogal: false,
    lockTogal: false,
    details: null,
  }),
  created() {
    this.get();
  },
  methods: {
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },
    lock(id, state) {
      this.lockTogal = true;
      this.status = state;
    },
    get() {
      axios
        .get("admin/users/" + this.user)
        .then((res) => {
          this.details = res.data;
        })
        .catch((err) => console.log(err));
    },
    confirm() {
      axios
        .delete("admin/users/" + this.user)
        .then((res) => {
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    confirmLock() {
      var st = this.details.status == "Active" ? "Locked" : "Active";
      console.log("carrent status:", this.details.status);
      console.log("status will be:", st);
      axios
        .put("admin/users/lock/" + this.user, { status: st })
        .then((res) => {
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    cancel() {},
    refresh() {
      this.editTogal = false;
    },
  },
};
</script>
<style scoped lang="scss">
.md-card {
  text-align: left;
  .row {
    display: flex;
    > :first-child {
      width: 200px;
    }
  }
}
.unlocked {
  color: #25c925;
}
.locked {
  color: red;
}
</style>
