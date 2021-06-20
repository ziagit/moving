<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :cons="cons" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Vehicles" class="border-0 shadow text-left mt-5">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Code</th>
            <th>Value</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="cons in constans" :key="cons.id">
            <td>{{ cons.id }}</td>
            <td>{{ cons.name }}</td>
            <td>{{ cons.code }}</td>
            <td>
              <span v-if="cons.code == 'floortime'">min </span>
              <span v-else-if="cons.code == 'distance' || cons.code == 'disposalfee'"
                >$</span
              ><span v-else>%</span> {{ cons.value }}
            </td>
            <td>
              <b-button variant="light" @click="edit(cons)">
                <b-icon variant="primary" icon="pencil"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(cons.id)">
                <b-icon variant="danger" icon="trash"></b-icon>
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
  name: "cons",
  data: () => ({
    keywords: null,
    constans: null,
    cons: null,
  }),

  methods: {
    get() {
      axios
        .get("admin/constans")
        .then((res) => {
          this.constans = res.data;
          console.log("conss: ", res.data);
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
      this.cons = data;
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
        .delete("admin/constans/" + id)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    find() {
      axios.get("admin/constans/4").then((res) => {
        console.log("xxxxxxxxxxxxxxx", res.data);
      });
    },
  },
  created() {
    this.find();
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
