<template>
  <div>
    <b-modal id="modal-card" :hide-footer="true">
      <Card />
    </b-modal>
    <b-card header="Payment Method" class="shadow border-0 mt-5">
      <b-button @click="$emit('close-it')" class="add-btn" variant="light">
        <b-icon icon="x"></b-icon>
      </b-button>
      <div class="shipper-details" v-if="paymentMethod">
        <div class="row">
          <span class="col-3">Brand: </span>
          <span class="col-6">{{ paymentMethod[0].brand }}</span>
        </div>
        <div class="row">
          <span class="col-3">Last 4:</span>
          <span class="col-6">************{{ paymentMethod[0].last4 }}</span>
        </div>
        <div class="row">
          <span class="col-3">Expirateion date: </span>
          <span class="col-6"
            >{{ paymentMethod[0].exp_month }}/{{ paymentMethod[0].exp_year }}</span
          >
        </div>
      </div>
      <div class="row" v-else>
        <p>There is no payment method added</p>
      </div>
      <div class="text-right">
        <b-button v-if="paymentMethod" variant="primary" @click="editCard()"
          >Edit</b-button
        >
        <b-button v-else variant="primary" @click="editCard()">Add</b-button>
      </div>
    </b-card>
    <br />
    <b-card header="Edit Details" class="border-0 shadow">
      <form @submit.prevent="update" enctype="multipart/form-data">
        <b-button @click="$emit('close-it')" variant="light" class="add-btn">
          <b-icon icon="x"></b-icon>
        </b-button>
        <div class="shipper-details">
          <b-form-group>
            <b-input-group>
              <b-form-input
                type="text"
                v-model="form.first_name"
                ref="focusable"
                placeholder="First name"
              ></b-form-input>
              <b-form-input
                type="text"
                v-model="form.last_name"
                placeholder="Last name"
              ></b-form-input>
              <b-form-input
                type="tel"
                v-model="form.phone"
                placeholder="Phone"
              ></b-form-input>
            </b-input-group>
          </b-form-group>
          <b-form-group>
            <b-input-group>
              <b-form-input
                type="email"
                v-model="form.email"
                placeholder="Email"
              ></b-form-input>

              <GoogleAddress3
                v-if="form.address != null"
                v-on:google-valid-address="googleValidAddress"
                v-on:google-invalid-address="googleInvalidAddress"
                :initialData="form.address"
                label="Full adddress"
              />
            </b-input-group>
          </b-form-group>
        </div>
        <div class="text-right">
          <b-button type="submit" variant="primary">Update</b-button>
        </div>
      </form>
    </b-card>
  </div>
</template>

<script>
import GoogleAddress3 from "../../shared/GoogleAddress3.vue";
import Card from "../../frontend/card/Card.vue";
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
          console.log("card res", res.data.data);
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
    editCard() {
      this.$bvModal.show("modal-card");
    },
  },
};
</script>

<style scoped lang="scss">
.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
