<template>
  <div class="ranges" v-if="ranges">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="Are you sure what you doing?"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
    <!-- edit dialog -->
    <md-dialog :md-active.sync="editTogal">
      <md-dialog-title>Update range data</md-dialog-title>
      <md-dialog-content>
        <EditRateRange v-on:close-dialog="refresh" :range="range" />
      </md-dialog-content>
    </md-dialog>
    <!-- add dialog -->
    <md-dialog :md-active.sync="addTogal">
      <md-dialog-title>Add new range</md-dialog-title>
      <md-dialog-content>
        <AddRateRange v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">
            Rate ranges
            <md-menu md-direction="top-start" :md-active.sync="rangeInfo">
              <md-icon md-menu-trigger class="md-primary info">info</md-icon>
              <md-menu-content>
                <p style="padding: 0 20px !important">
                  6 range points is the limit,<br />
                  if you add more than 6, that will be<br />
                  considered as above 10k. <br />
                  <md-divider></md-divider>
                  !Please make sure to enter/update <br />
                  values sorted in ascending order.
                </p>
              </md-menu-content>
            </md-menu>
          </h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()"
          >Create new range</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>Value</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="(range, index) in ranges.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ range.name }}</md-table-cell>
        <md-table-cell>{{ range.value }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(range)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(range.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="ranges" @pagination-change-page="get"></pagination>
    <md-button class="md-fab md-primary add-btn" @click="add()">
      <md-icon>add</md-icon>
      <md-tooltip>Add new range</md-tooltip>
    </md-button>
  </div>
</template>

<script>
import axios from "axios";
import AddRateRange from "./AddRateRange";
import EditRateRange from "./EditRateRange";
export default {
  name: "RateRanges",
  data: () => ({
    keywords: null,
    ranges: null,
    range: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
    rangeInfo: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-rate-range", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.ranges = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/rate-ranges?page=" + page)
        .then((res) => {
          this.ranges = res.data;
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
      this.range = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/rate-ranges/" + this.selectedId)
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
    AddRateRange,
    EditRateRange,
  },
};
</script>

<style lang="scss" scoped>
.ranges {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
