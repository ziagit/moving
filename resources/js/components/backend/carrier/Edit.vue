<template>
  <form @submit.prevent="update" enctype="multipart/form-data">
    <b-card header="Edit Details" class="shadow border-0">
      <b-button variant="light" @click="$emit('close-it')" class="add-btn">
        <b-icon icon="x"></b-icon>
      </b-button>
      <div class="carrier-details">
        <b-form-group>
          <b-input-group>
            <b-form-input
              type="text"
              v-model="form.first_name"
              required
              ref="focusable"
              placeholder="First name"
            ></b-form-input>
            <b-form-input
              type="text"
              v-model="form.last_name"
              required
              placeholder="Last name"
            ></b-form-input>
            <b-form-input
              type="tel"
              v-model="form.phone"
              required
              placeholder="Phone"
            ></b-form-input>
          </b-input-group>
        </b-form-group>
        <b-form-group>
          <b-form-input></b-form-input>
        </b-form-group>
        <b-form-group>
          <b-input-group>
            <b-form-input
              v-model="form.company"
              required
              placeholder="Company name"
            ></b-form-input>
            <b-form-input
              type="number"
              v-model="form.year_established"
              required
              placeholder="Year established"
            ></b-form-input>
            <b-form-input v-model="form.website" placeholder="Website"></b-form-input>
          </b-input-group>
        </b-form-group>
        <b-form-group>
          <b-input-group>
            <b-form-input
              type="number"
              :min="1"
              v-model="form.employees"
              required
              placeholder="Number of employees"
            ></b-form-input>
            <b-form-input
              type="number"
              :min="1"
              v-model="form.vehicles"
              required
              placeholder="Number of vehicles"
            ></b-form-input>
            <b-form-input
              type="number"
              :min="1"
              v-model="form.hourly_rate"
              required
              placeholder="Hourly rate"
            ></b-form-input>
          </b-input-group>
        </b-form-group>
        <b-form-group>
          <b-form-textarea
            v-model="form.detail"
            required
            placeholder="Company details"
          ></b-form-textarea>
        </b-form-group>
        <b-form-group>
          <b-input-group>
            <b-form-file
              v-model="insurance_papers"
              accept="image/*"
              ref="insurance"
              @change="onInsuranceChange"
              placeholder="Upload Insurance paper"
            />
            <b-form-file
              v-model="business_license"
              accept="image/*"
              ref="license"
              @change="onLicenseChange"
              placeholder="Upload business licens"
            />
          </b-input-group>
        </b-form-group>
      </div>
      <div class="text-right mt-3">
        <b-button type="submit" variant="primary">Update</b-button>
      </div>
    </b-card>
  </form>
</template>

<script lang="ts">
import Vue from "vue";
import axios from "axios";
export default Vue.extend({
  props: ["carrier"],
  data: () => {
    return {
      id: null,
      form: {
        first_name: null,
        last_name: null,
        website: null,
        company: null,
        detail: null,
        country: null,
        state: null,
        city: null,
        zip: null,
        address: null,
        employees: null,
        vehicles: null,
        hourly_rate: null,
        year_established: null,
        phone: null,
        addressId: null,
      },
      logo: null,
      insurance_papers: null,
      business_license: null,
      oldLogo: null,
    };
  },
  created() {
    this.init();
  },
  methods: {
    update() {
      let fd = new FormData();
      fd.append("business_license", this.business_license);
      fd.append("insurance_papers", this.insurance_papers);
      fd.append("first_name", this.form.first_name);
      fd.append("last_name", this.form.last_name);
      fd.append("addressId", this.form.addressId);
      fd.append("country", this.form.country);
      fd.append("state", this.form.state);
      fd.append("city", this.form.city);
      fd.append("zip", this.form.zip);
      fd.append("address", this.form.address);
      fd.append("phone", this.form.phone);
      fd.append("website", this.form.website);
      fd.append("company", this.form.company);
      fd.append("detail", this.form.detail);
      fd.append("addressId", this.form.addressId);
      fd.append("employees", this.form.employees);
      fd.append("vehicles", this.form.vehicles);
      fd.append("hourly_rate", this.form.hourly_rate);
      fd.append("year_established", this.form.year_established);
      fd.append("userId", this.carrier.user.id);
      fd.append("_method", "put");
      axios
        .post("admin/carriers/" + this.id, fd)
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

    onChange(e) {
      this.logo = e.target.files[0];
    },
    onLicenseChange(e) {
      this.business_license = e.target.files[0];
    },
    onInsuranceChange(e) {
      this.insurance_papers = e.target.files[0];
    },
    init() {
      this.id = this.carrier.id;
      this.form.first_name = this.carrier.first_name;
      this.form.last_name = this.carrier.last_name;
      this.form.phone = this.carrier.user.phone;
      this.form.website = this.carrier.website;
      this.form.company = this.carrier.company;
      this.form.detail = this.carrier.detail;
      this.form.addressId = this.carrier.address.id;
      this.form.country = this.carrier.address.country;
      this.form.state = this.carrier.address.state;
      this.form.city = this.carrier.address.city;
      this.form.zip = this.carrier.address.zip;
      this.form.address = this.carrier.address.formatted_address;
      this.form.employees = this.carrier.employees;
      this.form.vehicles = this.carrier.vehicles;
      this.form.hourly_rate = this.carrier.hourly_rate;
      this.form.year_established = this.carrier.year_established;
    },
  },
});
</script>

<style scoped lang="scss">
.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
