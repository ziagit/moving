<template>
  <div>
    <Edit
      v-if="editTogal"
      v-on:close-it="refresh"
      :user="details"
      v-on:refresh="refresh"
    />
    <md-card v-else>
      <md-card-header>
        <span class="md-title">Account Details</span>
        <md-button to="/admin/carriers" class="md-icon-button add-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
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

    get() {
      axios
        .get("admin/users/" + this.user)
        .then((res) => {
          this.details = res.data;
        })
        .catch((err) => console.log(err));
    },

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
.add-btn {
  position: absolute;
  top: 1px;
  right: 1px;
}
</style>
