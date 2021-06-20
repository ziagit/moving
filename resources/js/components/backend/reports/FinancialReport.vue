<template>
  <div class="container">
    <b-card
      v-if="result"
      id="printable"
      class="border-0 shadow mt-5 mb-5"
      :header="'ID: ' + result.order.uniqid"
    >
      <div class="no-print">
        <b-button variant="light" @click="printIt()"
          ><b-icon variant="primary" icon="printer">print</b-icon></b-button
        >
        <b-button variant="light" @click="download()"
          ><b-icon icon="download" variant="primary"></b-icon
        ></b-button>
      </div>
      <div class="px-4">
        <div class="row">
          <div class="col-8"></div>
          <div class="col-4">
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
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div><b>Revenue</b></div>
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
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div><b>Payouts/Expenses</b></div>
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
            <div>Notes: ...........</div>
            <div class="md-body-1">{{ result.order.instructions }}</div>
          </div>
        </div>
      </div>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
import dateFormatter from "../../frontend/services/dateFormatter";
export default {
  components: {},
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
    download() {
      var options = {
        //'width': 800,
      };
      var pdf = new jsPDF("p", "pt", "a4");
      pdf.addHTML("#content2", -1, 220, options, function () {
        pdf.save("admit_card.pdf");
      });
    },
  },
};
</script>
<style scoped lang="scss">
.container {
  min-height: calc(100vh - 50px);
  .no-print {
    position: absolute;
    top: 0;
    right: 0;
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
}
</style>
