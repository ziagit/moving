<template>
  <div>
    <Edit
      v-if="editTogal"
      v-on:close-it="refresh"
      :user="details"
      v-on:close-dialog="refresh"
    />
    <b-card v-else header="Account Details" class="shadow text-left border-0">
      <b-button variant="light" @click="$router.push('/admin/carriers')" class="add-btn">
        <b-icon icon="x"></b-icon>
      </b-button>
      <div v-if="details">
        <div class="row">
          <span class="col-3">Name: </span>
          <span class="col-6">{{ details.name }}</span>
        </div>
        <div class="row">
          <span class="col-3">Email: </span>
          <span class="col-6">{{ details.email }}</span>
        </div>
        <div class="row">
          <span class="col-3">Password: </span>
          <span class="col-6">********</span>
        </div>
        <div class="row">
          <span class="col-3">Status: </span>
          <span
            class="col-6"
            :class="[details.status == 'Active' ? 'unlocked' : 'locked']"
            >{{ details.status }}</span
          >
        </div>
      </div>
      <div class="text-right mt-3">
        <b-button variant="primary" @click="editTogal = true">Edit</b-button>
      </div>
    </b-card>
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
      this.get();
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
