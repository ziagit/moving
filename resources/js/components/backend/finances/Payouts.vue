<template>
  <div class="container" v-if="payouts">
    <b-modal id="modal-add" size="md" title="New Payout" :hide-footer="true">
      <NewPayout v-on:close-dialog="refresh" />
    </b-modal>
    <b-card class="border-0 shadow" header="Payouts">
      <b-form-input placeholder="Search by mover name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>Mover</th>
            <th>Date</th>
            <th>From</th>
            <th>To</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(payout, index) in payouts.data" :key="index">
            <td md-numeric>{{ payout.carrier.first_name }}</td>
            <td>{{ formatter(payout.created_at) }}</td>
            <td>{{ payout.from }}</td>
            <td>{{ payout.to }}</td>
            <td>${{ payout.amount }}</td>
          </tr>
        </tbody>
      </table>
      <div class="text-right">
        <b-button variant="primary" class="add-btn" v-b-modal.modal-add>New</b-button>
      </div>
    </b-card>
    <pagination :limit="4" :data="payouts" @pagination-change-page="get"></pagination>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import formatter from "../../frontend/services/dateFormatter";
import NewPayout from "./NewPayout";
import Toaster from "../../shared/Toaster.vue";
export default {
  components: { NewPayout, Toaster },
  name: "payouts",
  data: () => ({
    keywords: null,
    payouts: null,
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
        .get("admin/search-payout", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("response from payout", res.data.data);
          this.payouts = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    async get(page = 1) {
      axios
        .get("admin/payouts?page=" + page)
        .then((res) => {
          this.payouts = res.data;
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

    refresh() {
      this.$bvModal.hide("modal-add");
      this.$refs.toaster.show("success", "b-toaster-top-right", "Paid successfully!");
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
