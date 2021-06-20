<template>
  <div class="container">
    <b-modal id="modal-update" title="Update  Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :carrier="carrier" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add new " :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card class="border-0 shadow mt-5 mb-5" header="Mover page">
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>ID</th>
            <th>Titel</th>
            <th>Body</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="carrier in carriers" :key="carrier.id">
            <td md-numeric>{{ carrier.id }}</td>
            <td>{{ carrier.title }}</td>
            <td class="body" v-html="carrier.body"></td>
            <td md-label="Actions">
              <b-button variant="light" @click="edit(carrier)">
                <b-icon icon="pencil" variant="primary"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(carrier.id)">
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
  name: "carrier",
  data: () => ({
    keywords: null,
    carriers: null,
    carrier: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/carrier-page")
        .then((res) => {
          console.log("car", res.data);
          this.carriers = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.carrier = data;
      this.$bvModal.show("modal-update");
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/carrier/" + this.selectedId)
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
  min-height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
  .body {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}
</style>
