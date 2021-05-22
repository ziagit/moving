<template>
  <div class="addresses" v-if="addresses">
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
      <md-dialog-title>Update address</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :address="address" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="zip" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Customer Addresses</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by zip/city..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()"
          >Create new address</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Country</md-table-head>
        <md-table-head>Postal code</md-table-head>
        <md-table-head>City</md-table-head>
        <md-table-head>State</md-table-head>
        <md-table-head>Address</md-table-head>
        <md-table-head>Customer/Order</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="(address, index) in addresses.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ address.country }}</md-table-cell>
        <md-table-cell>{{ address.zip }}</md-table-cell>
        <md-table-cell>{{ address.city }}</md-table-cell>
        <md-table-cell>{{ address.state }}</md-table-cell>
        <md-table-cell>{{ address.formatted_address }}</md-table-cell>

        <md-table-cell>
          <span v-if="address.carrier.length > 0">{{ address.carrier[0].company }}</span>
          <span v-else-if="address.shipper.length > 0">{{
            address.carrier[0].first_name
          }}</span>
          <span v-else-if="address.orders">{{ address.orders[0].uniqid }}</span>
          <span v-else>None</span>
        </md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(address)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(address.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="addresses" @pagination-change-page="get"></pagination>
    <!--   <md-button class="md-fab md-primary add-btn" @click="add()">
      <md-icon>add</md-icon>
      <md-tooltip>Add new address</md-tooltip>
    </md-button> -->
  </div>
</template>

<script>
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "address",
  data: () => ({
    keywords: null,
    addresses: null,
    address: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-address", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          console.log(res.data.data);
          this.addresses = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/addresses?page=" + page)
        .then((res) => {
          console.log("address: ", res.data.data);
          this.addresses = res.data;
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
      this.address = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/addresses/" + this.selectedId)
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
    Edit,
  },
};
</script>

<style lang="scss" scoped>
.addresses {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
