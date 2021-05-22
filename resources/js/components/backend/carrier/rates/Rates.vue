<template>
  <div v-if="rates">
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
      <md-dialog-title>Update Rate</md-dialog-title>
      <md-dialog-content>
        <Edit v-on:close-dialog="refresh" :rate="rate" />
      </md-dialog-content>
    </md-dialog>

    <md-table md-sort="zip" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Rates</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by company..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No rate found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()">Create new rate</md-button>
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Hourly rate</md-table-head>
        <md-table-head>Company</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="(rate, index) in rates.data" :key="index">
        <md-table-cell md-numeric>{{ index + 1 }}</md-table-cell>
        <md-table-cell>${{ rate.price }}</md-table-cell>
        <md-table-cell>{{ rate.carrier ? rate.carrier.company : "" }}</md-table-cell>

        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-primary" @click="edit(rate)">
            <md-icon>edit</md-icon>
          </md-button>
          <md-button class="md-icon-button md-accent" @click="remove(rate.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="rates" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import axios from "axios";
import Add from "./Add";
import Edit from "./Edit";
export default {
  name: "rate",
  data: () => ({
    keywords: null,
    rates: null,
    rate: null,
    deleteTogal: false,
    addTogal: false,
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
        .get("admin/search-rate", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.rates = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/rates?page=" + page)
        .then((res) => {
          this.rates = res.data;
          console.log("rates ", res.data.data);
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
      this.rate = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/rates/" + this.selectedId)
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

<style lang="scss" scoped>
.shipper-orders {
  .md-card {
    text-align: center;

    .table {
      width: 100%;
      border-collapse: collapse;

      th,
      td {
        border: 1px solid #ddd;
        text-align: center;
      }

      .delivered {
        color: green !important;
      }
    }

    .temp-order {
      background: #e7ecf3;
      border-radius: 5px;
      padding-left: 5px;
      display: flex;
      justify-content: space-between;
      align-items: center;

      div {
        display: flex;
        align-items: center;
      }
    }

    .close-btn {
      position: absolute;
      top: 0;
      right: 0;
    }
  }
}
</style>

<script>
import axios from "axios";
import Add from "./Add";
import Edit from "./Edit";
export default {
  name: "rate",
  data: () => ({
    keywords: null,
    rates: null,
    rate: null,
    deleteTogal: false,
    addTogal: false,
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
        .get("admin/search-rate", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.rates = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/rates?page=" + page)
        .then((res) => {
          this.rates = res.data;
          console.log("rates ", res.data.data);
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
      this.rate = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/rates/" + this.selectedId)
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

<style lang="scss" scoped>
.rates {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
