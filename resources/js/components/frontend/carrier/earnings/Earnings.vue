<template>
  <div>
    <md-card>
      <md-card-header>
        <span class="md-title">Earning History</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <md-tabs>
          <md-tab id="tab-home" md-label="Unpaid" exact>
            <Unpaid />
          </md-tab>
          <md-tab id="tab-pages" md-label="Paid" exact>
            <Paid />
          </md-tab>
        </md-tabs>
      </md-card-content>
    </md-card>
  </div>
</template>

<script>
import Paid from "./Paid";
import Unpaid from "./Unpaid";

export default {
  name: "earnings",
  data: () => ({}),
  components: {
    Paid,
    Unpaid,
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .table {
    width: 100%;
    border-collapse: collapse;
    overflow: auto;

    th,
    td {
      border: 1px solid #ddd;
      text-align: center;
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
.note {
  text-align: left;
  .md-body-2 {
    color: #ffa500;
  }
}
@media only screen and (max-width: 1150px) {
  .table {
    overflow-x: auto;
  }
}
</style>
