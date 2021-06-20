<template>
  <div class="container" v-if="users">
    <Edit
      v-if="editTogal"
      v-on:cancel="editTogal = false"
      v-on:refresh="refresh"
      :user="user"
    />
    <Add v-if="addTogal" v-on:cancel="addTogal = false" v-on:refresh="refresh" />
    <b-card v-if="!editTogal && !addTogal" header="Users" class="shadow border-0 mt-5">
      <b-form-input placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Access</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users.data" :key="index">
            <td md-numeric>{{ index + 1 }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.phone }}</td>
            <td>
              <span v-for="role in user.roles" :key="role.id">{{ role.name }}</span>
            </td>
            <td>
              <span :class="[user.status == 'active' ? 'unlocked' : 'locked']">{{
                user.status
              }}</span>
            </td>

            <td md-label="Actions">
              <b-button variant="light" @click="edit(user)">
                <b-icon variant="primary" icon="pencil"></b-icon>
              </b-button>
              <b-button
                variant="light"
                v-if="user.roles[0].name != 'admin'"
                @click="change(user.id, 'Deleted')"
              >
                <b-icon variant="danger" icon="trash"></b-icon>
              </b-button>
              <div v-if="user.roles[0].name != 'admin'">
                <b-button
                  variant="light"
                  v-if="user.status == 'Active'"
                  @click="change(user.id, 'Locked')"
                >
                  <b-icon icon="lock" variant="danger"></b-icon>
                </b-button>
                <b-button v-else variant="light" @click="change(user.id, 'Active')">
                  <b-icon variant="success" icon="unlock"></b-icon>
                </b-button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button variant="light" class="add-btn" @click="addTogal = true">
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
    <pagination :limit="4" :data="users" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Edit from "./Edit";
import Add from "./Add";
export default {
  name: "Users",
  components: {
    Edit,
    Add,
  },
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

    change(id, status) {
      this.$bvModal
        .msgBoxConfirm("Do you want this account to be " + status + "?")
        .then((value) => {
          if (value) {
            this.confirm(id, status);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    confirm(id, status) {
      if (status == "Deleted") {
        this.remove(id);
      } else {
        this.lock(id, status);
      }
    },
    remove(id) {
      console.log("id", id);
      axios
        .delete("admin/users/" + id)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    lock(id, status) {
      axios
        .put("admin/users/lock/" + id, { status: status })
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
};
</script>
<style scoped lang="scss">
.container {
  min-height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
