<template>
  <div>
    <div class="md-body-2">Filter By</div>
    <div class="row">
      <md-field>
        <md-select v-model="form.month" placeholder="Month">
          <md-option value="1">January</md-option>
          <md-option value="2">February</md-option>
          <md-option value="3">March</md-option>
          <md-option value="4">April</md-option>
          <md-option value="5">May</md-option>
          <md-option value="6">June</md-option>
          <md-option value="7">July</md-option>
          <md-option value="8">August</md-option>
          <md-option value="9">September</md-option>
          <md-option value="10">October</md-option>
          <md-option value="11">November</md-option>
          <md-option value="12">December</md-option>
        </md-select>
      </md-field>
      <md-field>
        <md-select v-model="form.status" placeholder="Payment status">
          <md-option value="Paid">Paid</md-option>
          <md-option value="Unpaid">Unpaid</md-option>
          <md-option value="Refunded">Refunded</md-option>
        </md-select>
      </md-field>
    </div>
    <div class="action">
      <md-button class="md-primary" @click="filter()">Filter</md-button>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    form: {
      month: null,
      status: null,
    },
  }),
  methods: {
    filter() {
      this.$emit("close-dialog", this.form);
    },
  },
};
</script>
<style scoped>
.row {
  display: flex;
  justify-content: space-between;
}
.action {
  text-align: right;
}
</style>
