<template>
  <div class="main-container">
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
      <md-dialog-title>Update data</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :cons="cons" />
      </md-dialog-content>
    </md-dialog>
    <!-- add dialog -->
    <md-dialog :md-active.sync="addTogal">
      <md-dialog-title>Add new </md-dialog-title>
      <md-dialog-content>
        <Add v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Constants</h1>
        </div>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()">Create new</md-button>
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Name</md-table-head>
        <md-table-head>Code</md-table-head>
        <md-table-head>Value</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="cons in constans" :key="cons.id">
        <md-table-cell md-numeric>{{ cons.id }}</md-table-cell>
        <md-table-cell>{{ cons.name }}</md-table-cell>
        <md-table-cell>{{ cons.code }}</md-table-cell>
        <md-table-cell
          ><span v-if="cons.code == 'floortime'">min </span>
          <span v-else-if="cons.code == 'distance' || cons.code == 'disposalfee'">$</span
          ><span v-else>%</span> {{ cons.value }}</md-table-cell
        >

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(cons)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(cons.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <md-button class="md-fab md-primary add-btn" @click="add()">
      <md-icon>add</md-icon>
      <md-tooltip>Add new </md-tooltip>
    </md-button>
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
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
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
      this.cons = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/constans/" + this.selectedId)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    cancel() {},
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
.main-container {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
