<template>
  <div class="contacts" v-if="contacts">
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
      <md-dialog-title>Update Contacts</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :contact="contact" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="name" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Customer Contacts</h1>
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
          >Create New Contact</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Contact name</md-table-head>
        <md-table-head>Phone</md-table-head>
        <md-table-head>Email</md-table-head>
        <md-table-head>Customer/Order</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="(contact, index) in contacts.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>{{ contact.name }}</md-table-cell>
        <md-table-cell>{{ contact.phone }}</md-table-cell>
        <md-table-cell>{{ contact.email }}</md-table-cell>
        <md-table-cell>{{
          contact.carrier != null ? contact.carrier.company : contact.orders.uniqid
        }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(contact)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(contact.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="contacts" @pagination-change-page="get"></pagination>
    <!-- <md-button class="md-fab md-primary add-btn" @click="add()">
      <md-icon>add</md-icon>
      <md-tooltip>Add new contact</md-tooltip>
    </md-button> -->
  </div>
</template>

<script>
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "contact",
  data: () => ({
    keywords: null,
    contacts: null,
    contact: null,
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
        .get("admin/search-contact", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.contacts = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/contacts?page=" + page)
        .then((res) => {
          console.log("contacts: ", res.data.data);
          this.contacts = res.data;
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
      this.contact = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/customer/contacts/" + this.selectedId)
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
.contacts {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
