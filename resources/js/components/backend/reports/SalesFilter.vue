<template>
  <div>
    <b-form-group>
      <b-input-group>
        <b-form-datepicker
          v-model="form.from"
          placeholder="Start date"
          :max="new Date()"
          data-date-format="yyyy-mm-dd"
        ></b-form-datepicker>
        <b-form-datepicker
          v-model="form.to"
          placeholder="End date"
          :max="new Date()"
        ></b-form-datepicker>
      </b-input-group>
    </b-form-group>
    <b-form-group>
      <b-input-group>
        <b-form-select v-model="form.order_status" placeholder="Order status">
          <b-form-select-option :value="null">Status</b-form-select-option>
          <b-form-select-option value="">َAll</b-form-select-option>
          <b-form-select-option value="New">New</b-form-select-option>
          <b-form-select-option value="Accepted">Accepted</b-form-select-option>
          <b-form-select-option value="Declined">Declined</b-form-select-option>
          <b-form-select-option value="Canceled">Canceled</b-form-select-option>
          <b-form-select-option value="Completed">Completed</b-form-select-option>
        </b-form-select>
        <b-form-select v-model="form.type" placeholder="Type">
          <b-form-select-option :value="null">Type</b-form-select-option>
          <b-form-select-option value="">All</b-form-select-option>
          <b-form-select-option value="office">Office</b-form-select-option>
          <b-form-select-option value="apartment">Apartment</b-form-select-option>
          <b-form-select-option value="few_items">A few items</b-form-select-option>
          <b-form-select-option value="junk_removal">Junk removal</b-form-select-option>
        </b-form-select>
      </b-input-group>
    </b-form-group>
    <b-form-group>
      <b-form-select v-model="form.mover" placeholder="Mover">
        <b-form-select-option :value="null">Mover</b-form-select-option>
        <b-form-select-option value="">All</b-form-select-option>
        <b-form-select-option value="Amu">Amu cloud</b-form-select-option>
        <b-form-select-option value="TingsApp">TingsApp</b-form-select-option>
      </b-form-select>
    </b-form-group>
    <div class="action">
      <b-button variant="primary" @click="filter()">Filter</b-button>
    </div>
  </div>
</template>
<script>
export default {
  data: () => ({
    form: {
      from: null,
      to: null,
      order_status: null,
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
