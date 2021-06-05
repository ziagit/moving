<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card>
        <md-card-header>
          <span class="md-title">Edit Details</span>
          <md-button
            @click="$emit('close-it')"
            class="md-icon-button add-btn"
          >
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
                <label for="">Payment method</label>
                <md-input v-model="form.card"></md-input>
              </md-field>
            </div>
            <div class="row">
              <md-button>Edit payment method</md-button>
            </div>
          </div>
        </md-card-content>
        <md-card-actions>
          <md-button type="submit" class="md-primary">Update</md-button>
        </md-card-actions>
      </md-card>
    </form>
  </div>
</template>
</template>

<script>
import Vue from "vue";
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
        email: null,
        addressId: null,
        userId: null,
      },
      editCardTogale:true,
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
          this.$emit("refresh");
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
    },
  },
});
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
