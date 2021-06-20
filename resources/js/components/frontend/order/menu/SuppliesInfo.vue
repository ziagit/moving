<template>
  <table class="table">
    <thead>
      <tr>
        <th>Item</th>
        <th>Size</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="supply in supplies" :key="supply.item">
        <td>{{ supply.item }}</td>
        <td>{{ supply.size }}</td>
        <td>{{ supply.price }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "SuppliesInfo",
  data: () => ({
    supplies: [
      { item: "Small box", size: "16X12X12 Inches", price: "$2" },
      { item: "Medium box", size: "22X16X16 Inches", price: "$3" },
      { item: "Large box", size: "28X16X16 Inches", price: "$5" },
      { item: "Tape", size: "48mmX50m", price: "$5" },
      { item: "Stretch wrap", size: "15in X 750Ft", price: "$20" },
    ],
  }),
};
</script>

<style lang="scss" scoped>
.info {
  padding: 20px;
  min-width: 100%;
  min-height: 100%;
  .table {
    width: 100%;
    border-collapse: collapse;

    th {
      font-size: 11px;
      color: #666;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 2px;
    }
  }
}
</style>
