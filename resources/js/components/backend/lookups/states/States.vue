<template>
  <div class="container" v-if="states">
    <b-modal id="modal-update" title="Update Country Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :state="state" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add new country" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card class="border-0 shadow text-left mt-5" header="States">
      <b-form-input type="search" placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <tr>
          <th md-numeric>ID</th>
          <th>Name</th>
          <th>Country</th>
          <th>Actions</th>
        </tr>
        <tr v-for="state in states.data" :key="state.id">
          <td md-numeric>{{ state.id }}</td>
          <td>{{ state.name }}</td>
          <td>{{ state.country.name }}</td>
          <td>
            <b-button variant="light" @click="edit(state)">
              <b-icon icon="pencil" variant="primary"></b-icon>
            </b-button>
            <b-button variant="light" @click="remove(state.id)">
              <b-icon icon="trash-fill" variant="danger"></b-icon>
            </b-button>
          </td>
        </tr>
      </table>
      <b-button class="add-btn" variant="primary" v-b-modal.modal-add>
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
    <pagination :limit="4" :data="states" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "States",
  data: () => ({
    keywords: null,
    states: null,
    state: null,
    countryId: null,
    addDialog: false,
    editDialog: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-state", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("search data: ", res.data.data);
          this.states = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/states?page=" + page)
        .then((res) => {
          this.states = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addDialog = true;
    },
    edit(state) {
      this.state = state;
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
    refresh() {
      this.$bvModal.hide("modal-update");
      this.$bvModal.hide("modal-add");
      this.get();
    },
    confirm(id) {
      axios
        .delete("admin/states/" + id)
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
    top: 0px;
    right: 0px;
  }
}
</style>
