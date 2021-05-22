<template>
  <div class="countries" v-if="countries">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="I assure what you doing"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="onCancel"
    />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editTogal">
      <md-dialog-title>Update Country Data</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :country="countryData" />
      </md-dialog-content>
    </md-dialog>
    <!-- add dialog -->
    <md-dialog :md-active.sync="addTogal">
      <md-dialog-title>Add new country</md-dialog-title>
      <md-dialog-content>
        <Add v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Countries</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>Code</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="country in countries.data" :key="country.id">
        <md-table-cell md-numeric>{{ country.id }}</md-table-cell>
        <md-table-cell>{{ country.name }}</md-table-cell>
        <md-table-cell>{{ country.code }}</md-table-cell>

        <md-table-cell>
          <md-button class="md-icon-button md-primary" @click="edit(country)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(country.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="countries" @pagination-change-page="get"></pagination>
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
  name: "Countries",
  data: () => ({
    keywords: null,
    countries: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
    selectedId: 0,
    countryData: {},
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-country", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("search data: ", res.data.data);
          this.countries = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/countries?page=" + page)
        .then((res) => {
          console.log("countries: ", res.data);
          this.countries = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addTogal = true;
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.editTogal = true;
      this.countryData = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/countries/" + this.selectedId)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    onCancel() {},
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
.countries {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
.md-table-content {
  width: 100% !important;
}
</style>
