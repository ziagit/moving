<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :supply="supply" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Supplies" class="border-0 shadow text-left mt-5">
      <table class="table">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Code</th>
          <th>Price</th>
        </tr>
        <tr v-for="supply in supplies" :key="supply.id">
          <td md-numeric>{{ supply.id }}</td>
          <td>{{ supply.name }}</td>
          <td>{{ supply.code }}</td>
          <td>${{ supply.price }}</td>
          <td>
            <b-button variant="light" @click="edit(supply)">
              <b-icon variant="primary" icon="pencil"></b-icon>
            </b-button>
            <b-button variant="light" @click="remove(supply.id)">
              <b-icon variant="danger" icon="trash"></b-icon>
            </b-button>
          </td>
        </tr>
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
  name: "supply",
  data: () => ({
    keywords: null,
    supplies: null,
    supply: null,
  }),

  methods: {
    get() {
      axios
        .get("admin/supply")
        .then((res) => {
          this.supplies = res.data;
          console.log("supplies: ", res.data);
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
      this.supply = data;
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
        .delete("admin/supply/" + id)
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
  height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
