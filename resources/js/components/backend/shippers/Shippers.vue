<template>
  <div class="shippers" v-if="shippers">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="Do you want to delete?"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
    <EditShipper :shipper="shipper" v-on:close-it="editTogal = false" v-if="editTogal" />
    <md-table md-sort="first_name" md-sort-order="asc" md-card v-else>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Customers</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>Email</md-table-head>
        <md-table-head>Phone</md-table-head>
        <md-table-head>Address</md-table-head>
        <md-table-head>Payment method</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="shipper in shippers.data" :key="shipper.id">
        <md-table-cell md-numeric>{{ shipper.id }}</md-table-cell>
        <md-table-cell>{{ shipper.first_name }}</md-table-cell>
        <md-table-cell>{{ shipper.user ? shipper.user.email : "" }}</md-table-cell>
        <md-table-cell>{{ shipper.user ? shipper.user.phone : "" }}</md-table-cell>
        <md-table-cell>{{ shipper.address.formatted_address }}</md-table-cell>
        <md-table-cell>{{ shipper.card }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(shipper)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(shipper.id)">
            <md-icon>delete</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(shipper.id)">
            <md-icon>lock</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="shippers" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import axios from "axios";
import EditShipper from "./EditShipper";
export default {
  name: "shipper",
  data: () => ({
    keywords: null,
    shippers: null,
    shipper: null,
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
        .get("admin/search-shipper", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.shippers = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/shippers?page=" + page)
        .then((res) => {
          console.log("shpers: ", res.data.data);
          this.shippers = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },

    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },
    edit(data) {
      this.editTogal = true;
      this.shipper = data;
    },

    confirm() {
      axios
        .delete("admin/shippers/" + this.selectedId)
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
    EditShipper,
  },
};
</script>

<style lang="scss" scoped>
.shippers {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
