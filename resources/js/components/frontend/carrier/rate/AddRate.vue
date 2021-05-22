<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <md-card>
        <md-card-header>
          <div class="md-title">New rate</div>
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
                    <md-select v-model="form.vehicle_id" name="name" id="name" md-dense>
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
          <md-button type="submit" class="md-primary md-small-fab">Save</md-button>
        </md-card-actions>
      </md-card>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
import { mapGetters } from "vuex";
export default {
  name: "AddRate",
  data: () => ({
    form: {
      vehicle_id: null,
      number: null,
      price: null,
    },
    vehicles: null,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  components: {
    Snackbar,
  },
  computed: {
    ...mapGetters({
      temp: "shared/temp",
    }),
  },
  methods: {
    submit() {
      axios
        .post("carrier/rate", this.form)
        .then((res) => {
          this.$router.back();
          console.log("res ", res.status);
        })
        .catch((err) => {
          this.snackbar.show = true;
          this.snackbar.message = err.response.data.message;
          this.snackbar.statusCode = err.response.status;
          console.log("Error: ", err.response);
        });
    },
    getVehicles() {
      axios
        .get("vehicles")
        .then((res) => {
          this.vehicles = res.data;
          console.log("vehicles:", res.data);
        })
        .catch((err) => console.log(err));
    },
  },

  created() {
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
