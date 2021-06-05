<template>
  <div class="carriers" v-if="carriers">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="Are you sure, want to delete?"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />

    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Carriers</h1>
        </div>
        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by company name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()"
          >Create new carrier</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Company name</md-table-head>
        <md-table-head>Email</md-table-head>
        <md-table-head>Phone</md-table-head>
        <md-table-head>Details</md-table-head>
      </md-table-row>
      <md-table-row v-for="(carrier, index) in carriers.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ carrier.company }}</md-table-cell>
        <md-table-cell>{{ carrier.user.email }}</md-table-cell>
        <md-table-cell>{{ carrier.user.phone }}</md-table-cell>
        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(carrier)">
            <md-icon>more_horiz</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="carriers" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Edit from "./Edit";
export default {
  name: "carrier",
  data: () => ({
    keywords: null,
    carriers: null,
    carrier: null,
    deleteTogal: false,
    editTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-carrier", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.carriers = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/carriers?page=" + page)
        .then((res) => {
          this.carriers = res.data;
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
      this.$router.push("carrier-details/" + data.id);
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/carriers/" + this.selectedId)
        .then((res) => {
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
    Edit,
  },
};
</script>

<style lang="scss" scoped>
.carriers {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
