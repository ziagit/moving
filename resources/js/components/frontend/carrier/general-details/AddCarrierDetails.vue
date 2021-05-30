<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <md-card>
        <md-card-header>
          <span class="md-title">Add Details</span>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <div class="inputs-container">
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
              <md-field>
                <label for="">Email</label>
                <md-input type="text" v-model="form.email" required :min="0"></md-input>
              </md-field>
            </div>
            <div class="row">
              <GoogleAddress3
                v-on:google-valid-address="googleValidAddress"
                v-on:google-invalid-address="googleInvalidAddress"
                :initialData="form.address"
                label="Full adddress"
              />
            </div>
          </div>
          <div class="company">
            <div class="row">
              <md-field>
                <label>Company Name</label>
                <md-input v-model="form.company" required></md-input>
              </md-field>
              <md-field>
                <label>Year established</label>
                <md-input
                  type="number"
                  v-model="form.year_established"
                  required
                ></md-input>
              </md-field>
            </div>

            <div class="row">
              <md-field>
                <label>Website(optional)</label>
                <md-input type="url" v-model="form.website"></md-input>
              </md-field>
              <md-field>
                <label for="">Number of employees</label>
                <md-input
                  type="number"
                  :min="1"
                  v-model="form.employees"
                  required
                ></md-input>
              </md-field>
              <md-field>
                <label for="">Number of vehicles</label>
                <md-input
                  type="number"
                  :min="1"
                  v-model="form.vehicles"
                  required
                ></md-input>
              </md-field>
              <md-field>
                <label for="">Hourly rate</label>
                <md-input type="number" :min="1" v-model="form.rate" required></md-input>
              </md-field>
            </div>

            <div class="row">
              <md-field>
                <label>About your company</label>
                <md-textarea v-model="form.detail" required></md-textarea>
              </md-field>
            </div>
            <div class="row">
              <md-field>
                <md-tooltip>Upload Insurance paper</md-tooltip>
                <md-file
                  accept="image/*"
                  ref="insurance"
                  @change="onInsuranceChange"
                  placeholder="Upload Insurance paper"
                />
              </md-field>
              <md-field>
                <md-tooltip>Upload business licens</md-tooltip>
                <md-file
                  accept="image/*"
                  ref="license"
                  @change="onLicenseChange"
                  placeholder="Upload business licens"
                />
              </md-field>
            </div>
          </div>
        </md-card-content>
        <md-card-actions>
          <Spinner v-if="isSubmitting" />
          <md-button v-if="!isSubmitting" type="submit" class="md-primary md-small-fab"
            >Save</md-button
          >
        </md-card-actions>
      </md-card>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
export default {
  name: "AddGeneralInfo",
  components: {
    Snackbar,
    Spinner,
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
      rate: null,
      year_established: null,
      email: null,
      website: null,
      company: null,
      detail: null,
    },
    insurance_papers: null,
    business_license: null,
    isSubmitting: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  mounted() {
    this.$refs.focusable.$el.focus();
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
      fd.append("website", this.form.website);
      fd.append("company", this.form.company);
      fd.append("detail", this.form.detail);
      fd.append("addressId", this.form.addressId);
      fd.append("contactId", this.form.contactId);
      fd.append("employees", this.form.employees);
      fd.append("vehicles", this.form.vehicles);
      fd.append("year_established", this.form.year_established);
      axios
        .post("carrier/details", fd)
        .then((res) => {
          this.isSubmitting = false;
          console.log("response ", res.data);
          this.$router.push("/carrier/profile");
        })
        .catch((error) => {
          this.isSubmitting = false;
          console.log("eerrr: ", error.response);
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
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
