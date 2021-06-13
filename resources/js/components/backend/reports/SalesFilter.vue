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
        <md-select v-model="form.order_status" placeholder="Order status">
          <md-option value="Completed">Completed</md-option>
          <md-option value="New">New</md-option>
          <md-option value="Accepted">Accepted</md-option>
          <md-option value="Declined">Declined</md-option>
          <md-option value="Canceled">Canceled</md-option>
        </md-select>
      </md-field>
      <md-field>
        <md-select v-model="form.type" placeholder="Type">
          <md-option value="office">Office</md-option>
          <md-option value="apartment">Apartment</md-option>
          <md-option value="few_items">A few items</md-option>
          <md-option value="junk_removal">Junk removal</md-option>
        </md-select>
      </md-field>
    </div>
    <div class="row">
      <md-field>
        <md-select v-model="form.pickup" placeholder="Pickup">
          <md-option value="Vancouver">Vancouver</md-option>
          <md-option value="Victoria">Victoria</md-option>
        </md-select>
      </md-field>
      <md-field>
        <md-select v-model="form.destination" placeholder="Destination">
          <md-option value="Vancouver">Vancouver</md-option>
          <md-option value="Victoria">Victoria</md-option>
        </md-select>
      </md-field>
      <md-field>
        <md-select v-model="form.mover" placeholder="Mover">
          <md-option value="Amu">Amu cloud </md-option>
          <md-option value="TingsApp">TingsApp</md-option>
        </md-select>
      </md-field>
    </div>
    <div class="action">
      <md-button class="md-primary" @click="filter()">Filter</md-button>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    form: {
      month: null,
      order_status: null,
      pickup: null,
      destination: null,
      mover: null,
      type: null,
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
