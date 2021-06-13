<template>
  <div>
    <md-dialog :md-active.sync="checkoutTogal">
      <md-dialog-content>
        <Card v-on:close-dialog="refresh" />
      </md-dialog-content>
    </md-dialog>
    <md-card>
      <md-card-header>
        <span class="md-title">Payment Method</span>
        <md-button @click="$emit('close-it')" class="md-icon-button add-btn">
          <md-icon>close</md-icon>
        </md-button>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="shipper-details">
          <div class="row" v-if="stripe_customer_id">
            <p>{{ paymentMethod.brand }}</p>
            <p>************{{ paymentMethod.last4 }}</p>
            <p>{{ paymentMethod.exp_month }}/{{ paymentMethod.exp_year }}</p>
            <md-button class="md-primary" @click="checkoutTogal = true">Edit</md-button>
          </div>
          <div class="row">
            <p>There is no payment method added</p>
            <md-button class="md-button" @click="checkoutTogal = true">Add </md-button>
          </div>
        </div>
      </md-card-content>
    </md-card>
    <br />
    <md-card>
      <form @submit.prevent="update" enctype="multipart/form-data">
        <md-card-header>
          <span class="md-title">Edit Details</span>
          <md-button @click="$emit('close-it')" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
          </md-button>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <div class="shipper-details">
            <div class="row">
              <md-field>
                <label for="">First name</label>
                <md-input
                  type="text"
                  v-model="form.first_name"
                  required
                  ref="focusable"
                ></md-input>
              </md-field>
              <md-field>
                <label for="">Last name</label>
                <md-input type="text" v-model="form.last_name" required></md-input>
              </md-field>
              <div class="row">
                <md-field>
                  <label for="">Phone</label>
                  <md-input type="tel" v-model="form.phone" required></md-input>
                </md-field>
                <md-field>
                  <label for="">Email</label>
                  <md-input type="tel" v-model="form.email" required></md-input>
                </md-field>
              </div>
            </div>
            <div class="row">
              <GoogleAddress3
                v-if="form.address != null"
                v-on:google-valid-address="googleValidAddress"
                v-on:google-invalid-address="googleInvalidAddress"
                :initialData="form.address"
                label="Full adddress"
              />
            </div>
          </div>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">Update</md-button>
        </md-card-actions>
      </form>
    </md-card>
  </div>
</template>

<script>
import GoogleAddress3 from "../../shared/GoogleAddress3.vue";
import Card from "./Card.vue";
export default {
  props: ["shipper"],
  components: {
    GoogleAddress3,
    Card,
  },
  data: () => {
    return {
      form: {
        first_name: null,
        last_name: null,
        country: null,
        state: null,
        city: null,
        zip: null,
        address: null,
        phone: null,
        email: null,
        addressId: null,
        userId: null,
      },
      checkoutTogal: false,
      paymentMethod: null,
      stripe_customer_id: null,
    };
  },
  created() {
    this.init();
  },
  methods: {
    googleValidAddress(address, latlng) {
      this.supportedArea = "";
      this.form.country = address.country;
      this.form.state = address.state;
      this.form.city = address.city;
      this.form.zip = address.zip;
      this.form.street = address.street;
      this.form.street_number = address.street_number;
      this.form.address = address.formatted_address;
    },
    googleInvalidAddress(address) {
      this.supportedArea = address.state;
      this.form.country = null;
      this.form.state = null;
      this.form.city = null;
      this.form.zip = null;
      this.form.street = null;
      this.form.street_number = null;
      this.form.address = null;
    },
    refresh(data) {
      this.checkoutTogal = false;
      this.getCard();
    },
    getCard() {
      axios
        .get("admin/card-details/" + this.shipper.stripe_customer_id)
        .then((res) => {
          console.log("card res", res.data);
          if (res.data.data) {
            this.paymentMethod = res.data.data;
          }
          this.dataLoading = false;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    update() {
      axios
        .put("admin/shippers/" + this.shipper.id, this.form)
        .then((res) => {
          console.log("res", res.data);
          this.$emit("close-it");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },
    init() {
      this.form.first_name = this.shipper.first_name;
      this.form.last_name = this.shipper.last_name;
      this.form.phone = this.shipper.user.phone;
      this.form.email = this.shipper.user.email;
      this.form.addressId = this.shipper.address.id;
      this.form.country = this.shipper.address.country;
      this.form.state = this.shipper.address.state;
      this.form.city = this.shipper.address.city;
      this.form.zip = this.shipper.address.zip;
      this.form.address = this.shipper.address.formatted_address;
      this.form.userId = this.shipper.user.id;
      if (this.shipper.stripe_customer_id) {
        this.getCard();
      }
    },
  },
};
</script>

<style scoped lang="scss">
.md-card {
  text-align: left;

  .select-logo {
    position: absolute;
  }

  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .md-field {
      flex: 25%;
    }
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }

  .zip-address {
    flex: 50%;
  }
}
.company {
  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .md-field {
      flex: 32%;
    }
  }
}
</style>
