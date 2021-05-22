<template>
  <div>
    <!-- print invoice -->
    <md-dialog :md-active.sync="printTogal" :md-fullscreen="true">
      <md-dialog-title>Service Provider Invoice</md-dialog-title>
      <md-dialog-content>
        <Invoices v-on:close-dialog="close" :dataToPrint="earnings" />
      </md-dialog-content>
    </md-dialog>
    <md-card md-theme="orange-card">
      <md-card-header>
        <div class="md-title">Generated Invoices</div>
        <!--    <md-button
          @click="print()"
          class="md-icon-button add-btn"
          v-if="earnings.length != 0"
        >
          <md-icon>print</md-icon>
          <md-tooltip>Print invoice</md-tooltip>
        </md-button> -->
      </md-card-header>
      <md-card-content>
        <md-empty-state
          class="md-primary"
          md-icon="credit_card"
          md-label="$0"
          md-description="List of generated invoices will be showing here"
        ></md-empty-state>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Invoices from "./Invoices";
import axios from "axios";
import functions from "../../frontend/services/functions";
export default {
  name: "earnings",
  data: () => ({
    earnings: [],
    total: 0,
    dataToPrint: null,
    printTogal: false,
  }),
  components: {
    Invoices,
  },
  methods: {
    getearnings() {
      axios
        .get("admin/earnings")
        .then((res) => {
          this.earnings = res.data;
          console.log("res..", res.data);
          this.calculateTotal(res.data);
        })
        .catch((err) => {
          console.log("error", err);
        });
    },
    calculateTotal(data) {
      data.forEach((element) => {
        let subtotal =
          element.distance_charge +
          element.moving_charge +
          element.vehicle_charge +
          element.service_charge +
          element.supplies_charge +
          element.tax;
        this.total = this.total + subtotal;
      });
    },
    print() {
      this.printTogal = true;
    },
    close() {
      this.printTogal = false;
    },
    formatter(date) {
      return functions.myDateFormat(date);
    },
  },
  created() {
    this.getearnings();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none;
  border: 1px solid #ddd;
  text-align: center;

  .md-card-content {
    overflow-x: auto;
  }

  .table {
    width: 100%;
    border-collapse: collapse;

    th,
    td {
      border: 1px solid #ddd;
    }
    .body {
      tr {
        td {
          font-size: 12px;
        }
      }
    }
    .delivered {
      color: green !important;
    }
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
