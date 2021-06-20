<template>
  <div class="container" v-if="refunds">
    <b-modal id="modal-add" size="md" title="New Refund" :hide-footer="true">
      <NewRefund v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Refunds" class="border-0 shadow mt-5 mb-5">
      <b-form-input placeholder="Search by mover name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>#</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(refund, index) in refunds.data" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ refund.shipper.first_name }}</td>
            <td>{{ formatter(refund.created_at) }}</td>
            <td>${{ refund.amount }}</td>
          </tr>
        </tbody>
      </table>
      <div class="text-right">
        <b-button variant="primary" class="add-btn" v-b-modal.modal-add>New</b-button>
      </div>
    </b-card>
    <pagination :limit="4" :data="refunds" @pagination-change-page="get"></pagination>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import formatter from "../../frontend/services/dateFormatter";
import NewRefund from "./NewRefund";
import Toaster from "../../shared/Toaster.vue";
export default {
  components: { NewRefund, Toaster },
  name: "refunds",
  data: () => ({
    keywords: null,
    refunds: null,
    totalCost: 0,
    totalPrice: 0,
    totalReceived: 0,
    totalPaid: 0,
    totalOwing: 0,
    totalGross: 0,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },

  methods: {
    search() {
      axios
        .get("admin/search-refund", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("res", res.data.data);
          this.refunds = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/refunds?page=" + page)
        .then((res) => {
          this.refunds = res.data;
          console.log("res.data", res.data.data);
          this.tCost(res.data.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    formatter(date) {
      return formatter.format(date);
    },

    tCost(data) {
      /* for (let i = 0; i < data.length; i++) {
        this.totalCost = this.totalCost + data[i].order.cost;
      } */
    },

    refresh(data) {
      this.$bvModal.hide("modal-add");
      this.$refs.toaster.show("success", "b-toaster-top-center", "Invalid Data", data);
      this.get();
    },
  },
  created() {
    this.get();
  },
};
</script>
<style scoped lang="scss">
.container {
  min-height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 1px;
    right: 1px;
  }
}
</style>
