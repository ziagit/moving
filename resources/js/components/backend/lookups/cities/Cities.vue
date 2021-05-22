<template>
  <div class="cities" v-if="cities">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="I assure what you doing"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editTogal">
      <md-dialog-title>Update city data</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :city="city" />
      </md-dialog-content>
    </md-dialog>
    <!-- add dialog -->
    <md-dialog :md-active.sync="addTogal">
      <md-dialog-title>Add new city</md-dialog-title>
      <md-dialog-content>
        <Add v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Cities</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()">Create new city</md-button>
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>State</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="city in cities.data" :key="city.id">
        <md-table-cell md-numeric>{{ city.id }}</md-table-cell>
        <md-table-cell md-sort-by="city.name">{{ city.name }}</md-table-cell>
        <md-table-cell>{{ city.state.name }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(city)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(city.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="cities" @pagination-change-page="get"></pagination>
    <md-button class="md-fab md-primary add-btn" @click="add()">
      <md-icon>add</md-icon>
      <md-tooltip>Add new city</md-tooltip>
    </md-button>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "City",
  components: {
    Add,
    Edit,
  },
  data: () => ({
    keywords: null,
    cities: null,
    city: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  created() {
    this.get();
  },

  methods: {
    search() {
      axios
        .get("admin/search-city", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("res ", res.data.data);
          this.cities = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/cities?page=" + page)
        .then((res) => {
          console.log("cities ", res.data.data);

          this.cities = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addTogal = true;
      this.stateData = this.states;
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.editTogal = true;
      this.city = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/cities/" + this.selectedId)
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
};
</script>
<style scoped lang="scss">
.cities {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
