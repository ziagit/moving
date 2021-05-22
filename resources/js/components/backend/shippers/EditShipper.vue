<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card class="main-card">
        <md-button
          @click="$emit('close-dialog')"
          class="md-icon-button add-btn"
        >
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
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
              <md-input
                type="text"
                v-model="form.last_name"
                required
              ></md-input>
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
            <md-field>
              <label for="">Address</label>
              <md-input v-model="form.address" required></md-input>
            </md-field>
            <md-field>
              <label for="">Country</label>
              <md-input v-model="form.country" required></md-input>
            </md-field>
            <md-field>
              <label for="">State</label>
              <md-input v-model="form.state" required></md-input>
            </md-field>
          </div>
          <div class="row">
            <md-field>
              <label for="">City</label>
              <md-input v-model="form.city" required></md-input>
            </md-field>
            <md-field>
              <label for="">Postal code</label>
              <md-input v-model="form.zip" required></md-input>
            </md-field>
          </div>
        </div>

        <md-button type="submit" class="md-primary md-small-fab"
          >Done</md-button
        >
      </md-card>
    </form>
  </div>
</template>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";
export default Vue.extend({
  props: ["shipper"],
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
        email:null,
        addressId: null,
        contactId: null,
      },
    };
  },
  created() {
    this.init();
  },
  methods: {
    update() {
      axios
        .put("admin/shippers/" + this.shipper.id, this.form)
        .then((res) => {
          console.log("res", res.data);
          this.$emit("close-dialog");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },

    init() {
        console.log("shipper to edit: ", this.shipper)
      this.form.first_name = this.shipper.first_name;
      this.form.last_name = this.shipper.last_name;
      this.form.phone = this.shipper.contact.phone;
      this.form.addressId = this.shipper.address.id;
      this.form.contactId = this.shipper.contact.id;
      this.form.country = this.shipper.address.country;
      this.form.state = this.shipper.address.state;
      this.form.city = this.shipper.address.city;
      this.form.zip = this.shipper.address.zip;
      this.form.address = this.shipper.address.formatted_address;
    },
  },
});
</script>

<style scoped lang="scss">
.main-card {
  padding: 30px;
  text-align: center;
  box-shadow: none;
  border: solid 1px #ddd;

  .shipper-logo {
    text-align: center;
    margin-top: -40px;

    .md-large {
      background: #ddd;
    }

    .select-logo {
      position: absolute;
    }
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
