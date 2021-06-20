<template>
  <div class="container">
    <b-card header="Edit User">
      <form @submit.prevent="update">
        <b-button variant="light" @click="$emit('cancel')" class="add-btn">
          <b-icon icon="x"></b-icon>
        </b-button>
        <div>
          <b-form-group>
            <b-form-input v-model="form.name" required placeholder="Name"></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-input
              v-model="form.email"
              required
              placeholder="Email"
            ></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-input
              v-model="form.phone"
              required
              placeholder="Phone"
            ></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-select v-model="form.role" placeholder="Role">
              <option v-for="role in roles" :key="role.id" :value="role.id">
                {{ role.name }}
              </option>
            </b-form-select>
          </b-form-group>
          <b-form-group>
            <b-input-group>
              <b-form-input
                type="password"
                v-model="form.password"
                required
                placeholder="New password"
              ></b-form-input>
              <b-form-input
                type="password"
                v-model="form.password_confirmation"
                required
                placeholder="Password confirmation"
              ></b-form-input>
            </b-input-group>
          </b-form-group>
        </div>
        <div class="text-right">
          <b-button type="submit" variant="primary">Save</b-button>
        </div>
      </form>
    </b-card>
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
