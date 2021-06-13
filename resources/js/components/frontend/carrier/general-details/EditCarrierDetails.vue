<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card>
        <md-card-header>
          <span class="md-title">Edit Profile</span>
          <md-button @click="$router.back()" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
            <md-tooltip>Cancel</md-tooltip>
          </md-button>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <div class="carrier-details">
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
                <label for="">Phone</label>
                <md-input v-model="form.phone" required></md-input>
              </md-field>
            </div>
            <div class="row">
              <GoogleAddress3
                v-if="form.address != null"
                v-on:google-valid-address="googleValidAddress"
                v-on:google-invalid-address="googleInvalidAddress"
                :initialData="form.address"
                label="Full address"
              />
            </div>
          </div>

          <div class="company">
            <div class="row">
              <md-field>
                <label>Company name</label>
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
              <md-field>
                <label>Website</label>
                <md-input v-model="form.website"></md-input>
              </md-field>
            </div>
            <div class="row">
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
                <label for="">Hourly rate($)</label>
                <md-input
                  type="number"
                  :min="1"
                  v-model="form.hourly_rate"
                  required
                  prefix="$"
                ></md-input>
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
                  v-model="insurance_papers"
                  accept="image/*"
                  ref="insurance"
                  @change="onInsuranceChange"
                  placeholder="Upload Insurance paper"
                />
              </md-field>
              <md-field>
                <md-tooltip>Upload business licens</md-tooltip>
                <md-file
                  v-model="business_license"
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
            >Update</md-button
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
import { mapGetters } from "vuex";
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
export default {
  name: "EditGeneralInfo",
  components: {
    GoogleAddress3,
    Snackbar,
    Spinner,
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
          this.isSubmitting = false;
          this.$router.push("/carrier/profile");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.isSubmitting = false;
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },
    init() {
      axios.get("carrier/details/" + this.$route.params.id).then(
        (res) => {
          console.log("res: ", res.data);
          this.form.first_name = res.data.first_name;
          this.form.last_name = res.data.last_name;
          this.form.email = this.user.email;
          this.form.phone = this.user.phone;
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
