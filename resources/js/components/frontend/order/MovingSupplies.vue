<template>
  <div class="origin">
    <span class="md-display-1"
      >Do you need moving supplies?
      <b-button id="popover-target-1" variant="ligth">
        <b-icon icon="info-circle-fill" aria-hidden="true"></b-icon>
      </b-button>
      <b-popover target="popover-target-1" triggers="hover" placement="top">
        <template #title>Price breakdown</template>
        <SuppliesInfo />
      </b-popover>
    </span>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="next()">
      <div class="options">
        <div v-for="(supply, index) in supplies" :key="index" class="row">
          <b-form-checkbox
            v-model="form.supplies.enabled[index]"
            :value="supply.name"
            class="md-check"
            @change="checkboxToggle($event, index)"
          >
            {{ supply.name }}
          </b-form-checkbox>

          <input
            type="number"
            class="number"
            :min="1"
            :max="100"
            :disabled="!form.supplies.enabled[index]"
            :required="form.supplies.enabled[index]"
            v-model="form.supplies.number[index]"
          />
        </div>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <b-button @click="back()" variant="light">
          <b-icon icon="arrow-left"></b-icon>
        </b-button>
        <div class="tab"></div>
        <b-button type="submit" variant="primary">
          <b-icon icon="arrow-right"></b-icon>
        </b-button>
      </div>
    </form>
  </div>
</template>

<script>
import SuppliesInfo from "./menu/SuppliesInfo";
import localData from "../services/localData";
export default {
  name: "Supplies",
  components: {
    SuppliesInfo,
  },
  data() {
    return {
      togal: false,
      supplies: [],
      form: {
        supplies: {
          enabled: [],
          number: [],
        },
      },
    };
  },
  created() {
    this.get();
    this.init();
    this.$emit("progress", 6);
  },
  methods: {
    checkboxToggle(supply, index) {
      if (supply == null) {
        this.form.supplies.number.splice(index, 1, null);
      }
    },
    back() {
      this.$router.push("/order/moving-date");
    },
    next() {
      localData.save("supplies", this.form.supplies);
      this.$router.push("movers");
    },
    checkSupplies() {
      var flag = false;
      this.form.supplies.number.forEach((element) => {
        if (element != null) {
          flag = true;
        }
      });
    },
    get() {
      axios
        .get("moving-supplies")
        .then((res) => {
          this.supplies = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    init() {
      let local = localData.read("supplies");
      if (local) {
        this.form.supplies.enabled = local.enabled.slice();
        this.form.supplies.number = local.number.slice();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
.origin {
  text-align: center;
  width: 100%;
}
.options {
  max-width: 300px;
  margin: auto;
  .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    .md-check {
      margin: 4px 4px 8px 0;
    }
    .number {
      width: 45px;
      border-radius: 5px;
      border: 0.5px solid #888;
    }
  }
}

.actions {
  display: flex;
  justify-content: center;
}
@media only screen and (max-width: 600px) {
}
</style>
