<template>
  <div>
    <form @submit.prevent="submit" class="border-0 shadow text-left">
      <b-card header="Add Profile">
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
            type="tel"
          ></b-form-input>
        </b-input-group>
        <GoogleAddress3
          v-on:google-valid-address="googleValidAddress"
          v-on:google-invalid-address="googleInvalidAddress"
          :initialData="form.address"
          label="Full address"
        />
        <b-input-group class="mb-3">
          <b-form-input
            v-model="form.company"
            required
            placeholder="Company name"
          ></b-form-input>
          <b-form-input
            type="number"
            v-model="form.year_established"
            required
            :min="1995"
            :max="2021"
            placeholder="Year established"
          ></b-form-input>
          <b-form-input
            v-model="form.website"
            placeholder="Website (optional)"
          ></b-form-input>
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
          <b-button v-if="!isSubmitting" type="submit" variant="primary">Save</b-button>
        </div>
      </b-card>
    </form>
    <Toaster ref="toast" />
  </div>
</template>
<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Toaster from "../../../shared/Toaster";
import validator from "../../services/validator";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "AddGeneralInfo",
  components: {
    Toaster,
    GoogleAddress3,
  },
  data: () => ({
    form: {
      first_name: null,
      last_name: null,
      addressId: null,
      country: null,
      state: null,
      city: null,
      zip: null,
      address: null,
      employees: null,
      vehicles: null,
      hourly_rate: null,
      year_established: null,
      email: null,
      phone: null,
      website: null,
      company: null,
      detail: null,
    },
    insurance_papers: null,
    business_license: null,
    isSubmitting: false,
  }),
  mounted() {
    this.$refs.focusable.focus();
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    googleValidAddress(address, latlng) {
      console.log("google add", address);
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
    onChange(e) {
      this.logo = e.target.files[0];
    },
    onLicenseChange(e) {
      this.business_license = e.target.files[0];
    },
    onInsuranceChange(e) {
      this.insurance_papers = e.target.files[0];
    },
    submit() {
      if (this.validate()) {
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
        fd.append("email", this.form.email);
        fd.append("phone", this.form.phone);
        fd.append("website", this.form.website);
        fd.append("company", this.form.company);
        fd.append("detail", this.form.detail);
        fd.append("addressId", this.form.addressId);
        fd.append("employees", this.form.employees);
        fd.append("vehicles", this.form.vehicles);
        fd.append("hourly_rate", this.form.hourly_rate);
        fd.append("year_established", this.form.year_established);
        axios
          .post("carrier/details", fd)
          .then((res) => {
            console.log("res", res.data);
            this.isSubmitting = false;
            this.$refs.toast.show(
              "success",
              "Successfull",
              "Your data saved successfully!"
            );
            this.$router.push("/carrier/profile");
          })
          .catch((error) => {
            this.isSubmitting = false;
            console.log("eerrr: ", error.response.data.errors);
            this.$refs.toast.show(
              "danger",
              "b-toaster-top-center",
              "Failed",
              "Invalid data provided"
            );
          });
      }
    },
    validate() {
      if (this.user.email) {
        if (validator.phoneValidator(this.form.phone)) {
          return true;
        } else {
          this.$refs.toast.show(
            "danger",
            "b-toaster-top-center",
            "Failed",
            "Please provide a valid phone number!"
          );
          return false;
        }
      } else {
        if (validator.emailValidator(this.form.email)) {
          return true;
        } else {
          this.snackbar.message = "Please provide a valid meail id!";
          this.snackbar.statusCode = 203;
          this.snackbar.show = true;
          return false;
        }
      }
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
  }
  .md-card-actions {
    display: flex;
    justify-content: flex-start;
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
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
