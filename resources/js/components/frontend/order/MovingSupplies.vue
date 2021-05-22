<template>
  <div class="supplies">
    <span class="md-display-1"
      >Do you need moving supplies?

      <md-menu md-direction="top-start" :md-active.sync="togal">
        <md-icon md-menu-trigger class="md-seconday info">info</md-icon>
        <md-menu-content>
          <SuppliesInfo />
        </md-menu-content>
      </md-menu>
    </span>
    <div class="break"></div>
    <div class="break"></div>
    <form @submit.prevent="next()">
      <div class="options">
        <div v-for="(supply, index) in supplies" :key="index" class="row">
          <md-checkbox
            type="checkbox"
            v-model="form.supplies.enabled[index]"
            :value="supply.name"
            class="md-check"
            @change="checkboxToggle($event, index)"
          >
            {{ supply.name }}
          </md-checkbox>
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
        <md-button
          to="/order/moving-date"
          class="md-raised md-fab md-icon-button rounded-primary-button"
        >
          <md-icon>arrow_back</md-icon>
        </md-button>
        <div class="tab"></div>

        <md-button
          type="submit"
          class="md-raised md-fab md-icon-button rounded-secondary-button"
        >
          <md-icon>arrow_forward</md-icon>
        </md-button>
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
.supplies {
  text-align: center;
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
