<template>
  <div>
    <md-card>
      <form @submit.prevent="update">
        <md-card-header>
          <span class="md-title">Add User</span>
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
          <div class="row">
            <md-field class="">
              <label>Email</label>
              <md-input v-model="form.email" required></md-input>
            </md-field>
            <md-field class="">
              <label>Phone</label>
              <md-input v-model="form.phone" required></md-input>
            </md-field>
          </div>
          <md-field>
            <md-select v-model="form.role" placeholder="Role">
              <md-option v-for="role in roles" :key="role.id" :value="role.id">{{
                role.name
              }}</md-option>
            </md-select>
          </md-field>
          <div class="row">
            <md-field>
              <label>New nassword</label>
              <md-input type="password" v-model="form.password" required></md-input>
            </md-field>
            <md-field>
              <label>Password confirmation</label>
              <md-input
                type="password"
                v-model="form.password_confirmation"
                required
              ></md-input>
            </md-field>
          </div>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">Save</md-button>
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
      form: {
        name: null,
        email: null,
        phone: null,
        role: null,
        password: null,
        password_confirmation: null,
      },
      roles: [],
    };
  },
  created() {
    this.getRoles();
  },
  methods: {
    update() {
      axios
        .post("admin/users", this.form)
        .then((res) => {
          this.$emit("refresh");
          console.log("added user: ", res.data);
        })
        .catch((err) => console.log("error: ", err));
    },
    getRoles() {
      axios
        .get("admin/roles")
        .then((res) => {
          console.log("roles", res.data);
          this.roles = res.data;
        })
        .catch((err) => console.log(err));
    },
  },
};
</script>
<style scoped>
.row {
  display: flex;
  justify-content: space-between;
}
.add-btn {
  position: absolute;
  top: 1px;
  right: 1px;
}
</style>
