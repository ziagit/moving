<template>
  <div class="info">
    <div class="content">
      <div class="md-body-2">Price breakdown</div>
      <div class="md-body-1">
        <span>Moving:</span>
        <span>${{ moving }}</span>
      </div>
      <div class="md-body-1">
        <span>Travel:</span>
        <span>${{ travel }}</span>
      </div>
      <div class="md-body-1" v-if="supplies">
        <span>Supplies:</span>
        <span>${{ supplies }}</span>
      </div>
      <div class="md-body-1" v-if="disposalFee">
        <span>Disposal fee:</span>
        <span>${{ disposalFee }}</span>
      </div>
      <div class="md-body-1">
        <span>Taxes:</span>
        <span>${{ tax }}</span>
      </div>
      <md-divider></md-divider>
      <div class="md-body-1">
        <span><b>Total:</b></span>
        <span
          ><b>${{ (moving + travel + supplies + tax).toFixed(2) }}</b></span
        >
      </div>
      <p class="details">
        The price includes basic damage protection. Your items are covered up to 60 cents
        per pound per item. This is the minimum coverage required by law. If you would
        like additional coverage, please contact your home/tenant insurance provider.
      </p>
    </div>
  </div>
</template>
<script>
export default {
  props: ["price"],
  data: () => ({
    moving: null,
    supplies: null,
    tax: null,
    travel: null,
    disposalFee: null,
  }),
  methods: {},
  created() {
    this.moving = this.price.moving;
    this.supplies = this.price.supplies_cost;
    this.tax = this.price.tax;
    this.travel = this.price.travel;
    this.disposalFee = this.price.disposal_fee;
  },
};
</script>
<style lang="scss" scoped>
.info {
  min-width: 100%;
  min-height: 100%;
  .content {
    padding: 20px;
    .md-body-1 {
      display: flex;
      justify-content: space-between;
    }
    .details {
      white-space: initial;
    }
  }
}
</style>
