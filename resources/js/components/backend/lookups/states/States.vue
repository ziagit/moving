<template>
  <div class="states" v-if="states">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteDialog"
      md-title="I assure what you doing"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editDialog">
      <md-dialog-title>Update State Data</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :state="state" />
      </md-dialog-content>
    </md-dialog>
    <!-- add dialog -->
    <md-dialog :md-active.sync="addDialog">
      <md-dialog-title>Add new state</md-dialog-title>
      <md-dialog-content>
        <Add v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">States</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>Country</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>

      <md-table-row v-for="state in states.data" :key="state.id">
        <md-table-cell md-numeric>{{ state.id }}</md-table-cell>
        <md-table-cell>{{ state.name }}</md-table-cell>
        <md-table-cell>{{ state.country.name }}</md-table-cell>
        <md-table-cell>
          <md-button class="md-icon-button" @click="edit(state)">
            <md-icon class="md-primary">edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(state.id)">
            <md-icon class="md-danger">delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="states" @pagination-change-page="get"></pagination>
    <md-button class="md-fab md-primary add-btn" @click="add()">
      <md-icon>add</md-icon>
      <md-tooltip>Add new country</md-tooltip>
    </md-button>
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
    deleteDialog: false,
    deletedId: null,
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
      this.editDialog = true;
      this.state = state;
    },
    remove(id) {
      this.deleteDialog = true;
      this.deletedId = id;
    },
    refresh() {
      this.addDialog = false;
      this.editDialog = false;
      this.get();
    },
    confirm() {
      axios
        .delete("admin/states/" + this.deletedId)
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
.states {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
