<template>
  <div class="container" v-if="orders">
    <b-card header="Orders" class="border-0 shadow mt-5">
      <b-input type="search" placeholder="Search by Id..." v-model="keywords" />
      <table class="table" v-if="orders">
        <thead>
          <tr>
            <th md-numeric>ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Type</th>
            <th>Status</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders.data" :key="order.id">
            <td md-numeric>{{ order.uniqid }}</td>
            <td>{{ order.pickup_date }}</td>
            <td>{{ order.appointment_time }}</td>
            <td>{{ order.movingtype.title }}</td>
            <td>{{ order.status }}</td>
            <td md-label="Details">
              <b-button variant="light" @click="details(order.id)">
                <b-icon variant="primary" icon="three-dots"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(order.id)">
                <b-icon variant="danger" icon="trash"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
    </b-card>
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
      this.$router.push("orders/details/" + id);
    },
    remove(id) {
      this.$bvModal
        .msgBoxConfirm("Are you sure?")
        .then((value) => {
          if (value) {
            this.confirm(id);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
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
  },
  created() {
    this.get();
  },
};
</script>
<style scoped lang="scss">
.container {
  min-height: calc(100vh - 5px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
