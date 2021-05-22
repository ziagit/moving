<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card>
        <md-card-header>
          <div class="md-title">Edit rate</div>
          <md-button @click="$router.back()" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
            <md-tooltip>Cancel</md-tooltip>
          </md-button>
        </md-card-header>
        <md-card-content>
          <table class="table">
            <thead>
              <tr>
                <th>Vehicle</th>
                <th>Number</th>
                <th>Price/hr</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <md-field>
                    <label for="name">Name</label>
                    <md-select
                      v-model="form.vehicle_id"
                      name="name"
                      id="name"
                      md-dense
                      disabled
                    >
                      <md-option
                        v-for="vehicle in vehicles"
                        :key="vehicle.id"
                        :value="vehicle.id"
                        >{{ vehicle.name }}</md-option
                      >
                    </md-select>
                  </md-field>
                </td>
                <td>
                  <md-field>
                    <label>Number</label>
                    <md-input v-model="form.number"></md-input>
                  </md-field>
                </td>
                <td>
                  <md-field>
                    <label>Price($)</label>
                    <md-input v-model="form.price"></md-input>
                  </md-field>
                </td>
              </tr>
            </tbody>
          </table>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary md-small-fab">Done</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "EditRate",
  data: () => ({
    form: {
      vehicle_id: null,
      number: null,
      price: null,
    },
    vehicles: null,
  }),

  methods: {
    update() {
      axios
        .put("carrier/rate/" + this.$route.params.id, this.form)
        .then((res) => {
          this.$emit("show-snackbar");
          this.$router.back();
          console.log("res ", res.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    init() {
      axios
        .get("carrier/rate/" + this.$route.params.id)
        .then((res) => {
          this.form.vehicle_id = res.data.vehicle_id;
          this.form.number = res.data.number;
          this.form.price = res.data.price;
          console.log("rate: ", res.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    getVehicles() {
      axios
        .get("vehicles")
        .then((res) => {
          this.vehicles = res.data;
        })
        .catch((err) => console.log(err));
    },
  },

  created() {
    this.init();
    this.getVehicles();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none;
  border: 1px solid #ddd;
  text-align: center;

  .md-card-content {
    overflow-x: auto;
  }

  .table {
    width: 100%;
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
