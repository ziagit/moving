<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :type="type" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card class="border-0 shadow text-left mt-5" header="Moving Types">
      <b-form-input type="search" placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titel</th>
            <th>Code</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="type in types" :key="type.id">
            <td>{{ type.id }}</td>
            <td>{{ type.title }}</td>
            <td>{{ type.code }}</td>
            <td>
              <b-button variant="light" @click="edit(type)">
                <b-icon icon="pencil" variant="primary"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(type.id)">
                <b-icon icon="trash" variant="danger"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button variant="primary" class="add-btn" v-b-modal.modal-add>
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
  </div>
</template>
<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";
export default {
  name: "Type",
  components: {
    Add,
    Edit,
  },
  data: () => ({
    keywords: null,
    types: null,
    type: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),
  methods: {
    get() {
      axios
        .get("admin/moving-types")
        .then((res) => {
          this.types = res.data;
          console.log("types: ", res.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    refresh() {
      this.$bvModal.hide("modal-update");
      this.$bvModal.hide("modal-add");
      this.get();
    },
    edit(data) {
      this.type = data;
      this.$bvModal.show("modal-update");
    },
    remove(id) {
      this.$bvModal
        .msgBoxConfirm("Are you sure?")
        .then((value) => {
          if (value) {
            this.confirm(id);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    confirm(id) {
      axios
        .delete("admin/moving-types/" + id)
        .then((res) => {
          console.log("deleted", res.data);
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
  height: calc(100vh - 50px);
}
.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
