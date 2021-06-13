<template>
  <div>
    <md-card v-if="result" id="printable">
      <md-card-header>
        <span class="md-title">TingsApp</span>
        <div class="no-print">
          <md-button class="md-icon-button md-primary" @click="printIt()"
            ><md-icon class="md-primary">print</md-icon></md-button
          >
        </div>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="break"></div>
        <div class="row">
          <div class="col"></div>
          <div class="col">
            <table>
              <tr>
                <th>Order number</th>
                <th>{{ result.order.uniqid }}</th>
              </tr>
              <tr>
                <th>Date</th>
                <th>{{ dateFormatter(result.order.created_at) }}</th>
              </tr>
              <tr>
                <th>Total amount to be collected</th>
                <th>${{ result.tingsapp_earning }}</th>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">Revenue</div>
            <table>
              <tr>
                <th>Travel cost</th>
                <th>Moving cost</th>
                <th>Supplies cost</th>
                <th>Service fee</th>
                <th>Disposal fee</th>
                <th>Total cost of revenue</th>
              </tr>
              <tr>
                <td>${{ result.order.travel_cost }}</td>
                <td>${{ result.order.moving_cost }}</td>
                <td>${{ result.order.supplies_cost }}</td>

                <td>${{ result.order.service_fee }}</td>
                <td>${{ result.order.disposal_fee }}</td>
                <td>${{ result.order.cost }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">Payouts/Expenses</div>
            <table>
              <tr>
                <th>Recevied amount</th>
                <th>Payout amount</th>
                <th>Recevied GST</th>
                <th>Paid GST</th>
                <th>Unpaid GST</th>
                <th>Net profit</th>
              </tr>
              <tr>
                <td>${{ result.order.cost }}</td>
                <td>${{ result.carrier_earning }}</td>
                <td>${{ result.received_gst }}</td>

                <td>${{ result.paid_gst }}</td>

                <td>${{ result.unpaid_gst }}</td>
                <td>${{ result.tingsapp_earning }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>

        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">Notes:</div>
            <div class="md-body-1">{{ result.order.instructions }}</div>
          </div>
        </div>

        <div class="break"></div>
        <div class="row">...................</div>
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import Spinner from "../../shared/Spinner";
import axios from "axios";
import dateFormatter from "../../frontend/services/dateFormatter";
export default {
  components: {
    Spinner,
  },
  data: () => ({
    result: null,
    total: 0,
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/financial-reports/" + this.$route.params.id)
        .then((res) => {
          this.totalEarning(res.data);
          console.log("rx", res.data);
          this.result = res.data;
        })
        .catch((err) => console.log(err.response));
    },
    totalEarning(earning) {
      for (let i = 0; i < earning.length; i++) {
        this.total = this.total + earning.tingsapp_earning;
      }
    },
    monthName() {
      var d = new Date();
      return dateFormatter.monthName(d.getMonth() + 1);
    },
    totalAmount(data) {
      for (let i = 0; i < data.length; i++) {
        this.totalIncome = this.totalIncome + data[i].tingsapp_earning;
      }
    },
    dateFormatter(date) {
      return dateFormatter.format(date);
    },
    printIt() {
      window.print();
    },
  },
};
</script>
<style scoped lang="scss">
.md-card {
  margin-bottom: 30px;
  .md-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
  .md-card-content {
    padding: 18px 30px 30px 30px;
    .row {
      display: flex;
      justify-content: space-between;
      .col {
        width: 100%;
        margin: 1px;
      }
    }
  }
}

table {
  width: 100%;
  border: 1px solid #ddd;
  border-collapse: collapse;
  tr {
    border: 1px solid #ddd;
    td,
    th {
      border: 1px solid #ddd;
      text-align: left;
      padding: 5px;
    }
  }
}
.md-title {
  font-size: 20px !important;
}
</style>
