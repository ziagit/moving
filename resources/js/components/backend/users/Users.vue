<template>
  <div class="users" v-if="users">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="I assure what you doing"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
    <!-- block dialog-->
    <md-dialog-confirm
      :md-active.sync="lockTogal"
      md-title="Confirm to change account status"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirmLock()"
      @md-cancel="cancel"
    />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editTogal">
      <md-dialog-title>Update data</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :user="user" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Users</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>Email</md-table-head>
        <md-table-head>Roles</md-table-head>
        <md-table-head>Status</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="(user, index) in users.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ user.name }}</md-table-cell>
        <md-table-cell>{{ user.email }}</md-table-cell>
        <md-table-cell>
          <span v-for="role in user.roles" :key="role.id">{{ role.name }}</span>
        </md-table-cell>
        <md-table-cell>
          <span :class="[user.status == 'active' ? 'unlocked' : 'locked']">{{
            user.status
          }}</span>
        </md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button
            class="md-icon-button md-primary"
            @click="edit(user)"
            :disabled="user.status != 'active'"
          >
            <md-icon>edit</md-icon>
          </md-button>
          <md-button
            class="md-icon-button md-accent"
            @click="remove(user.id)"
            :disabled="user.status != 'active'"
          >
            <md-icon>delete</md-icon>
          </md-button>
          <md-button
            v-if="user.status == 'active'"
            class="md-icon-button"
            :class="[user.status == 'active' ? 'unlocked' : 'locked']"
            @click="lock(user.id, 'locked')"
          >
            <md-icon>lock_open</md-icon>
          </md-button>
          <md-button
            v-else
            class="md-icon-button md-accent"
            @click="lock(user.id, 'active')"
          >
            <md-icon>lock</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="users" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import axios from "axios";
import Edit from "./Edit";
export default {
  name: "user",
  data: () => ({
    keywords: null,
    users: null,
    user: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
    lockTogal: false,
    status: null,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-user", { params: { keywords: this.keywords } })
        .then((res) => {
          this.users = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/users?page=" + page)
        .then((res) => {
          console.log("users: ", res.data.data[0].name);
          this.users = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addTogal = true;
      this.stateData = this.states;
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.editTogal = true;
      this.user = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },
    lock(id, state) {
      this.lockTogal = true;
      this.selectedId = id;
      this.status = state;
    },

    confirm() {
      axios
        .delete("admin/users/" + this.selectedId)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    confirmLock() {
      axios
        .put("admin/users/lock/" + this.selectedId, { status: this.status })
        .then((res) => {
          console.log("blocked", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    cancel() {},
  },
  created() {
    this.get();
  },
  components: {
    Edit,
  },
};
</script>
<style scoped lang="scss">
.users {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
  .unlocked {
    color: #25c925;
  }
  .locked {
    color: red;
  }
}
</style>
