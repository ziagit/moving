<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :size="size" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Offices" class="border-0 shadow text-left mt-5">
      <b-form-input type="search" placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>ID</th>
            <th>Title</th>
            <th>Code</th>
            <th>Employees</th>
            <th>Hours to move</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(size, index) in sizes" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ size.title }}</td>
            <td>{{ size.code }}</td>
            <td>{{ size.employees }}</td>
            <td>{{ size.hours_to_move }}</td>
            <td>
              <b-button variant="light" @click="edit(size)">
                <b-icon icon="pencil" variant="primary"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(size.id)">
                <b-icon icon="trash" variant="danger"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button class="add-btn" variant="primary" v-b-modal.modal-add>
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
  name: "size",
  data: () => ({
    keywords: null,
    sizes: null,
  }),

  methods: {
    get() {
      axios
        .get("admin/office-sizes")
        .then((res) => {
          this.sizes = res.data;
          console.log("sizes: ", res.data);
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
      this.size = data;
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
        .delete("admin/office-sizes/" + id)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
  },
  components: {
    Add,
    Edit,
  },
};
</script>
<style scoped lang="scss">
.container {
  height: calc(100vh - 5px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
