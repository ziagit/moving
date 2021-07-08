<template>
  <div>
    <form @submit.prevent="update" class="border-0 shadow text-left">
      <b-card header="Edit Profile">
        <b-button @click="$router.back()" variant="light add-btn">
          <b-icon icon="backspace"></b-icon>
        </b-button>
        <div class="carrier-details">
          <b-input-group class="mb-3">
            <b-form-input
              type="text"
              v-model="form.first_name"
              required
              placeholder="First name"
              ref="focusable"
            ></b-form-input>
            <b-form-input
              type="text"
              v-model="form.last_name"
              required
              placeholder="Last name"
            ></b-form-input>
            <b-form-input
              placeholder="Phone number"
              v-model="form.phone"
              required
            ></b-form-input>
          </b-input-group>
          <GoogleAddress3
            v-if="form.address != null"
            v-on:google-valid-address="googleValidAddress"
            v-on:google-invalid-address="googleInvalidAddress"
            :initialData="form.address"
            label="Full address"
            class="mb-3"
          />
        </div>
        <b-input-group class="mb-3">
          <b-form-input
            v-model="form.company"
            required
            placeholder="Company name"
          ></b-form-input>
          <b-form-input
            v-model="form.year_established"
            required
            placeholder="Year established"
          ></b-form-input>
          <b-form-input v-model="form.website" placeholder="Website"></b-form-input>
        </b-input-group>
        <b-input-group class="mb-3">
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
            prepend="$"
            type="number"
            :min="1"
            v-model="form.hourly_rate"
            required
            prefix="$"
            placeholder="Hourly rate($)"
          ></b-form-input>
        </b-input-group>
        <b-input-group class="mb-3">
          <b-form-textarea
            v-model="form.detail"
            required
            rows="3"
            max-rows="6"
            placeholder="About your company"
          ></b-form-textarea>
        </b-input-group>
        <b-input-group class="mb-3">
          <b-form-file
            v-model="insurance_papers"
            :state="Boolean(insurance_papers)"
            placeholder="Upload Insurance paper"
            drop-placeholder="Drop file here..."
            @change="onInsuranceChange"
          ></b-form-file>
          <b-form-file
            v-model="business_license"
            :state="Boolean(business_license)"
            placeholder="Upload business licens"
            drop-placeholder="Drop file here..."
            @change="onLicenseChange"
          ></b-form-file>
        </b-input-group>

        <div class="text-right">
          <b-spinner variant="primary" v-if="isSubmitting" />
          <b-button v-if="!isSubmitting" type="submit" variant="primary">Update</b-button>
        </div>
      </b-card>
    </form>
    <Toaster ref="toast" />
  </div>
</template>

<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import { mapGetters } from "vuex";
import Toaster from "../../../shared/Toaster";
export default {
  name: "EditGeneralInfo",
  components: {
    GoogleAddress3,
    Toaster,
  },
  data: () => ({
    initialData: null,
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
      contactId: null,
    },
    logo: null,
    insurance_papers: null,
    business_license: null,
    oldLogo: null,
    countries: null,
    isSubmitting: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
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

    onLicenseChange(e) {
      this.business_license = e.target.files[0];
    },
    onInsuranceChange(e) {
      this.insurance_papers = e.target.files[0];
    },
    update() {
      this.isSubmitting = true;
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
      fd.append("_method", "put");
      axios
        .post("carrier/details/" + this.$route.params.id, fd)
        .then((res) => {
          console.log("xx", res.data);
          this.isSubmitting = false;
          this.$refs.toast.show("success", "My body", "my title");
          //this.$router.push("/carrier/profile");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.isSubmitting = false;
          this.$$refs.toast.show(
            "danger",
            "Failed to update",
            error.response.data.errors
          );
        });
    },

    init() {
      axios.get("carrier/details/" + this.$route.params.id).then(
        (res) => {
          console.log("res: ", res.data);
          this.form.first_name = res.data.first_name;
          this.form.last_name = res.data.last_name;
          this.form.email = res.data.user.email;
          this.form.phone = res.data.user.phone;
          this.form.website = res.data.website;
          this.form.company = res.data.company;
          this.form.detail = res.data.detail;
          this.form.addressId = res.data.address.id;
          this.form.country = res.data.address.country;
          this.form.state = res.data.address.state;
          this.form.city = res.data.address.city;
          this.form.zip = res.data.address.zip;
          this.form.address = res.data.address.formatted_address;
          this.form.employees = res.data.employees;
          this.form.vehicles = res.data.vehicles;
          this.form.hourly_rate = res.data.hourly_rate;
          this.form.year_established = res.data.year_established;
        },
        (err) => {
          console.log(err);
        }
      );
    },
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  margin-bottom: 30px;
  text-align: left;
  .md-card-content {
    padding: 20px;
    .row {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;

      .md-field {
        flex: 25%;
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
  }
  .md-card-actions {
    display: flex;
    justify-content: flex-start;
  }
}

.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
