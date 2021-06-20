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
      <label for="">Status</label>
      <b-form-select v-model="form.status" placeholder="Status">
        <b-form-select-option :value="null">All</b-form-select-option>
        <b-form-select-option value="Paid">Paid</b-form-select-option>
        <b-form-select-option value="Unpaid">Unpaid</b-form-select-option>
        <b-form-select-option value="Refunded">Refunded</b-form-select-option>
      </b-form-select>
    </b-form-group>
    <div class="text-right">
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
