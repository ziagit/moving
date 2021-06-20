<template>
  <div class="container">
    <b-modal id="modal-update" title="Update  Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :contact="contact" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add new " :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Contact Page" class="border-0 shadow mt-0 mb-0">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts" :key="contact.id">
            <td>{{ contact.id }}</td>
            <td>{{ contact.phone }}</td>
            <td>{{ contact.email }}</td>
            <td>
              <b-button variant="light" @click="edit(contact)">
                <b-icon icon="pencil" variant="primary"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(contact.id)">
                <b-icon icon="trash" variant="danger"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <!--     <b-button variant="primary" @click="add()">
        <b-icon icon="plus"></b-icon>
      </b-button> -->
    </b-card>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "Contact",
  data: () => ({
    keywords: null,
    contacts: null,
    contact: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/contact")
        .then((res) => {
          this.contacts = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    refresh() {
      this.editTogal = false;
      this.get();
    },
    edit() {
      this.$bvModal.show("modal-update");
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
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
  .body {
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }
}
</style>
