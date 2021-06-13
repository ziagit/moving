<template>
  <div>
    <md-card v-if="result" id="printable">
      <md-card-header>
        <span class="md-title">ID: {{ result.uniqid }}</span>
        <div class="no-print">
          <md-button class="md-icon-button md-primary" @click="printIt()"
            ><md-icon class="md-primary">print</md-icon></md-button
          >
        </div>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="row">
          <div class="col">
            <div class="md-title">Pickup</div>
            <div class="md-body-1">
              {{ result.addresses[0].formatted_address }}
            </div>
            <div class="md-body-1">Stairs</div>
          </div>
          <div class="col">
            <div class="md-title">Destination</div>
            <div class="md-body-1">
              {{ result.addresses[1].formatted_address }}
            </div>
            <div class="md-body-1">Stairs</div>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">Customer information</div>
            <div class="md-body-1">Email: {{ result.shipper_contacts.user.email }}</div>
            <div class="md-body-1">Phone: {{ result.shipper_contacts.user.phone }}</div>
          </div>
          <div class="col">
            <div class="md-title">Mover information</div>
            <div class="md-body-1">
              Email: {{ result.job_with_carrier.carrier_detail.user.email }}
            </div>
            <div class="md-body-1">
              Phone: {{ result.job_with_carrier.carrier_detail.user.phone }}
            </div>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">General Informations</div>
            <table>
              <tr>
                <th>Type</th>
                <th>Moving size</th>
                <th>Number of movers</th>
                <th>Vehicle</th>
                <th>Pick up date</th>
                <th>Appointment time</th>
                <th>Cost</th>
              </tr>
              <tr>
                <td>{{ result.movingtype.title }}</td>
                <td>
                  {{ result.movingszise ? result.movingszise.title : "" }}
                </td>
                <td>{{ result.movernumber.number }}</td>

                <td>{{ result.vehicle.name }}</td>
                <td>{{ result.pickup_date }}</td>
                <td>{{ result.appointment_time }}</td>
                <td>{{ result.cost }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">Selected Supplies</div>
            <table>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total price</th>
              </tr>
              <tr v-for="(sup, index) in result.supplies" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ sup.name }}</td>
                <td>{{ sup.pivot.number }}</td>
                <td>${{ sup.price }}</td>
                <td>${{ sup.price * sup.pivot.number }}</td>
              </tr>

              <tr>
                <th colspan="4">Total</th>
                <th>${{ suppliesTotal(result.supplies) }}</th>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="row" v-if="result.items.length > 0">
          <div class="col">
            <div class="md-title">Selected Items</div>
            <table>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Qty</th>
              </tr>
              <tr v-for="(item, index) in result.items" :key="index">
                <td>{{ index + 1 }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.number }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div class="md-title">Customer notes:</div>
            <div class="md-body-1">{{ result.instructions }}</div>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">
          <div class="col"></div>
          <div class="col">
            <table>
              <tr>
                <th>Total received amount</th>
                <th>${{ result.cost }}</th>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="row">...................</div>
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import Spinner from "../../shared/Spinner";
import axios from "axios";
export default {
  components: {
    Spinner,
  },
  data: () => ({
    result: null,
    id: "TAO202106071775124695",
  }),
  created() {
    this.get();
  },
  methods: {
    get() {
      axios
        .get("admin/sales-reports/" + this.$route.params.id)
        .then((res) => {
          console.log("resssssss", res.data);
          this.result = res.data;
        })
        .catch((err) => console.log(err.response));
    },
    suppliesTotal(supplies) {
      var total = 0;
      for (let i = 0; i < supplies.length; i++) {
        var subtotal = supplies[i].pivot.number * supplies[i].price;
        total = total + subtotal;
      }
      return total;
    },
    printIt() {
      window.print();
    },
  },
};
</script>
<style scoped lang="scss">
.md-card {
  margin-bottom: 30px;
  .md-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }
  .md-card-content {
    padding: 18px 30px 30px 30px;
    .row {
      display: flex;
      justify-content: space-between;
      .col {
        width: 100%;
        margin: 1px;
      }
    }
  }
}

table {
  width: 100%;
  border: 1px solid #ddd;
  border-collapse: collapse;
  tr {
    border: 1px solid #ddd;
    td,
    th {
      border: 1px solid #ddd;
      text-align: left;
      padding: 5px;
    }
  }
}
.md-title {
  font-size: 20px !important;
}
</style>
