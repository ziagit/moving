<template>
  <div class="container">
    <b-modal id="modal-filter" size="md" title="Filter By" :hide-footer="true">
      <SalesFilter v-on:close-dialog="refresh" />
    </b-modal>
    <b-card id="printable" header="Sales Reports" class="border-0 shadow mt-5 mb-5">
      <div class="no-print">
        <b-button variant="light" v-b-modal.modal-filter
          ><b-icon variant="primary" icon="filter-left"></b-icon
        ></b-button>
        <b-button variant="light" @click="printIt()"
          ><b-icon icon="printer" variant="primary"></b-icon
        ></b-button>
        <b-button variant="light" @click="download()"
          ><b-icon icon="download" variant="primary"></b-icon
        ></b-button>
      </div>
      <div>
        <div class="row mr-0">
          <div class="col-8"></div>
          <table class="col-4">
            <tr>
              <th>Quantity</th>
            </tr>
            <tr>
              <th>{{ orderQty }}</th>
            </tr>
          </table>
        </div>
        <div class="break"></div>
        <table v-if="result">
          <tr>
            <th>Order</th>
            <th>Type</th>
            <th>Order status</th>
            <th>Pickup</th>
            <th>Destination</th>
            <th>Completed at</th>
            <th>Cost</th>
            <th>Customer</th>
            <th>Mover</th>
          </tr>
          <tr v-for="(res, index) in result" :key="index">
            <td>
              <a @click="details(res.id)">{{ res.uniqid }}</a>
            </td>
            <td>{{ res.movingtype.title }}</td>
            <td>{{ res.status }}</td>
            <td>{{ res.addresses[0].city }}</td>
            <td>{{ res.addresses[0].city }}</td>
            <td>{{ dateFormatter(res.updated_at) }}</td>
            <td>${{ res.cost }}</td>
            <td>{{ res.shipper_contacts.first_name }}</td>
            <td>
              {{ res.job_with_carrier.carrier_detail.company }}
            </td>
          </tr>
        </table>
        <b-spinner v-else />
      </div>
    </b-card>
  </div>
</template>
<script>
import SalesFilter from "./SalesFilter";
import dateFormatter from "../../frontend/services/dateFormatter";
import jsPDF from "jspdf";
import axios from "axios";
export default {
  components: {
    SalesFilter,
  },
  data: () => ({
    result: null,
    orderQty: 0,
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/sales-reports")
        .then((res) => {
          console.log("res", res.data);
          this.totalOrders(res.data);
          this.result = res.data;
        })
        .catch((err) => console.log(err.response));
    },
    refresh(data) {
      axios
        .post("admin/filter-sales-report", data)
        .then((res) => {
          console.log("filter res", res.data);
          this.$bvModal.hide("modal-filter");
          this.result = res.data;
          this.totalOrders(res.data);
        })
        .catch((err) => console.log(err));
    },
    details(id) {
      this.$router.push("/admin/reports/sales-report/" + id);
    },

    dateFormatter(date) {
      return dateFormatter.format(date);
    },
    printIt() {
      window.print();
    },

    totalOrders(data) {
      var t = 0;
      for (let i = 0; i < data.length; i++) {
        t = t + 1;
      }
      this.orderQty = t;
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
      td {
        font-size: 12px;
      }
    }
  }
  .no-print {
    position: absolute;
    top: 1px;
    right: 1px;
  }
}
</style>
