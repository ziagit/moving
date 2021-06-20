<template>
  <div>
    <b-card header="Earning History" class="border-0 shadow text-left">
      <b-tabs>
        <b-tab title="Unpaid">
          <Unpaid />
        </b-tab>
        <b-tab title="Paid">
          <Paid />
        </b-tab>
      </b-tabs>
    </b-card>
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
@media only screen and (max-width: 1150px) {
}
</style>
