<template>
  <div class="container">
    <b-card
      v-if="result"
      :header="'ID: ' + result.uniqid"
      header-bg-variant="light"
      id="printable"
      class="border-0 shadow mt-5 mb-5"
    >
      <div class="no-print">
        <b-button variant="light" class="print-btn" @click="printIt()"
          ><b-icon variant="primary" icon="printer"></b-icon
        ></b-button>
      </div>
      <div class="px-4">
        <div class="row">
          <div class="col-md-6">
            <div><b>Pickup</b></div>
            <div>
              {{ result.addresses[0].formatted_address }}
            </div>
            <div>Stairs</div>
          </div>
          <div class="col-md-6">
            <div><b>Destination</b></div>
            <div>
              {{ result.addresses[1].formatted_address }}
            </div>
            <div>Stairs</div>
          </div>
        </div>
        <div class="break"></div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div><b>Customer information</b></div>
            <div>Email: {{ result.shipper_contacts.user.email }}</div>
            <div>Phone: {{ result.shipper_contacts.user.phone }}</div>
          </div>
          <div class="col">
            <div><b>Mover information</b></div>
            <div>Email: {{ result.job_with_carrier.carrier_detail.user.email }}</div>
            <div>Phone: {{ result.job_with_carrier.carrier_detail.user.phone }}</div>
          </div>
        </div>
        <div class="break"></div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div><b>General Informations</b></div>
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
                <td>${{ result.cost }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="break"></div>
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div><b>Selected Supplies</b></div>
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
        <div class="break"></div>
        <div class="row" v-if="result.items.length > 0">
          <div class="col">
            <div class=""><b>Selected Items</b></div>
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
        <div class="break"></div>
        <div class="row">
          <div class="col">
            <div>Notes:</div>
            <div>{{ result.instructions }}</div>
          </div>
        </div>
        <div class="break"></div>
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
      </div>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
export default {
  components: {},
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
.container {
  min-height: calc(100vh - 50px);
  .print-btn {
    position: absolute;
    top: 0;
    right: 0;
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
}
</style>
