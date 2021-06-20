<template>
  <div class="container">
    <b-modal id="modal-update" title="Update FAQ" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :shipper="faq" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add new FAQ" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Customer FAQ" class="border-0 shadow mt-5 mb-5">
      <table class="table">
        <tr>
          <th>ID</th>
          <th>Titel</th>
          <th>Body</th>
          <th>Actions</th>
        </tr>
        <tr v-for="faq in faqs" :key="faq.id">
          <td>{{ faq.id }}</td>
          <td>{{ faq.title }}</td>
          <td><div v-html="faq.body"></div></td>
          <td>
            <b-button variant="light" @click="edit(faq)">
              <b-icon icon="pencil" variant="primary"></b-icon>
            </b-button>
            <b-button variant="light" @click="remove(faq.id)">
              <b-icon variant="danger" icon="trash"></b-icon>
            </b-button>
          </td>
        </tr>
      </table>
      <b-button v-b-modal.modal-add variant="primary" class="add-btn">
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
  name: "faq",
  data: () => ({
    keywords: null,
    faqs: null,
    faq: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),

  methods: {
    get() {
      axios
        .get("admin/shipper-faq")
        .then((res) => {
          this.faqs = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    refresh() {
      this.$bvModal.hide("modal-add");
      this.$bvModal.hide("modal-update");
      this.get();
    },
    edit(data) {
      this.faq = data;
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
        .delete("admin/shipper-faq/" + id)
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
