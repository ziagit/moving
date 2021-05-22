<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card class="main-card">
        <md-button
          to="/admin/carriers"
          class="md-icon-button add-btn"
        >
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <div class="carrier-logo">
          <md-avatar class="md-large">
            <img :src="'/images/uploads/' + oldLogo" alt="Logo" />
            <md-field class="select-logo">
              <md-tooltip>Select new logo</md-tooltip>
              <md-file
                v-model="form.logo"
                name="logo"
                accept="image/*"
                ref="logo"
                @change="onChange"
              />
            </md-field>
          </md-avatar>
        </div>
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
              <md-input
                type="text"
                v-model="form.last_name"
                required
              ></md-input>
            </md-field>
            <md-field>
              <label for="">Phone</label>
              <md-input type="tel" v-model="form.phone" required></md-input>
            </md-field>
          </div>
          <div class="row">
            <md-field>
              <label for="">Country</label>
              <md-input v-model="form.country" required></md-input>
            </md-field>
            <md-field>
              <label for="">State</label>
              <md-input v-model="form.state" required></md-input>
            </md-field>

            <md-field>
              <label for="">City</label>
              <md-input v-model="form.city" required></md-input>
            </md-field>
          </div>
          <div class="row">
            <md-field>
              <label for="">Postal code</label>
              <md-input v-model="form.zip" required></md-input>
            </md-field>

            <md-field>
              <label for="">Address</label>
              <md-input v-model="form.address" required></md-input>
            </md-field>
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
  data: () => {
    return {
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
        year_established: null,
        phone: null,
        addressId: null,
        contactId: null,
      },
      logo: null,
      insurance_papers: null,
      business_license: null,
      oldLogo: null,
      carrier:null,
    };
  },
  created() {
    this.init();
  },
  methods: {
    update() {
      let fd = new FormData();
      fd.append("logo", this.logo);
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
      fd.append("contactId", this.form.contactId);
      fd.append("employees", this.form.employees);
      fd.append("year_established", this.form.year_established);
      fd.append("_method", "put");
      axios
        .post("admin/carriers/" + this.carrier, fd)
        .then((res) => {
          console.log("res", res.data)
          this.$router.push("/admin/carriers")
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
      axios.get("admin/carriers/" + this.$route.params.id).then((res) => {
        this.carrier = res.data.id;
        this.form.first_name = res.data.first_name;
        this.form.last_name = res.data.last_name;
        this.form.phone = res.data.contact.phone;
        this.form.website = res.data.website;
        this.form.company = res.data.company;
        this.form.detail = res.data.detail;
        this.form.addressId = res.data.address.id;
        this.form.contactId = res.data.contact.id;
        this.form.country = res.data.address.country;
        this.form.state = res.data.address.state;
        this.form.city = res.data.address.city;
        this.form.zip = res.data.address.zip;
        this.form.address = res.data.address.formatted_address;
        this.form.employees = res.data.employees;
        this.form.vehicles = res.data.vehicles;
        this.form.year_established = res.data.year_established;
        this.oldLogo = res.data.logo;
      }).catch(err=>{
        console.log(err)
      })
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

  .carrier-logo {
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
