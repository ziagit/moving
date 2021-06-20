<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :mover="mover" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Number of Movers" class="border-0 shadow text-left mt-5">
      <b-form-input type="search" placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>ID</th>
            <th>Number of Movers</th>
            <th>Code</th>
            <th>Recommended for</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="mover in movers" :key="mover.id">
            <td md-numeric>{{ mover.id }}</td>
            <td>{{ mover.number }}</td>
            <td>{{ mover.code }}</td>
            <td>{{ mover.recommended }}</td>
            <td md-label="Actions">
              <b-button variant="light" @click="edit(mover)">
                <b-icon icon="pencil" variant="primary"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(mover.id)">
                <b-icon icon="trash" variant="danger"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button variant="primary" v-b-modal.modal-add class="add-btn">
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
  name: "mover",
  data: () => ({
    keywords: null,
    movers: null,
    mover: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),
  methods: {
    get() {
      axios
        .get("admin/mover-number")
        .then((res) => {
          this.movers = res.data;
          console.log("movers: ", res.data);
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
      this.mover = data;
      this.$bvModal.show("modal-update");
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
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
        .delete("admin/mover-number/" + id)
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

  components: {
    Add,
    Edit,
  },
};
</script>
<style scoped lang="scss">
.container {
  height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
