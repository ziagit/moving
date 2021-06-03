<template>
  <div class="orders" v-if="orders">
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

    <md-table md-sort="name" md-sort-order="asc" md-card v-if="orders">
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Orders</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="Not found"
        :md-description="`Not added any order yet.`"
      >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>Pickup</md-table-head>
        <md-table-head>Destination</md-table-head>
        <md-table-head>Customer</md-table-head>
        <md-table-head>Status</md-table-head>
        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="order in orders.data" :key="order.id">
        <md-table-cell md-numeric>{{ order.uniqid }}</md-table-cell>
        <md-table-cell>{{ order.addresses[0].city }} </md-table-cell>
        <md-table-cell>{{ order.addresses[1].city }} </md-table-cell>
        <md-table-cell v-if="order.shipper">{{ order.shipper.first_name }}</md-table-cell>
        <md-table-cell>{{ order.status }}</md-table-cell>
        <md-table-cell md-label="Actions">
          <md-button class="md-icon-button md-accent" @click="remove(order.id)">
            <md-icon>delete</md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" @click="details(order.id)">
            <md-icon>more_horiz</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="orders" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import axios from "axios";
import Details from "./Details";

export default {
  name: "order",
  data: () => ({
    keywords: null,
    orders: null,
    orderId: null,
    deleteTogal: false,
    editTogal: false,
  }),
  components: {
    Details,
  },
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-order", { params: { keywords: this.keywords } })
        .then((res) => {
          this.orders = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/orders?page=" + page)
        .then((res) => {
          this.orders = res.data;
          console.log("orders: ", res.data.data);
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

    details(id) {
      this.$router.push("order-details/" + id);
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/orders/" + this.selectedId)
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
};
</script>
<style scoped lang="scss">
.orders {
  width: 100%;
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
