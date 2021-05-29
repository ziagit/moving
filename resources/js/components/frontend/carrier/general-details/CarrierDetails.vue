<template>
  <md-card>
    <md-card-header>
      <span class="md-title">Profile </span>
    </md-card-header>
    <md-divider></md-divider>
    <md-card-content v-if="carrier">
      <div>
        <div>
          <div class="row">
            <span>First name:</span>
            <span>{{ carrier.first_name }}</span>
          </div>
          <div class="row">
            <span>Last name:</span>
            <span>{{ carrier.last_name }}</span>
          </div>
          <div class="row">
            <span>Email:</span>
            <span>{{ carrier.contact.email }}</span>
          </div>
          <div class="row">
            <span>Phone:</span>
            <span>{{ carrier.id }}</span>
          </div>
          <div class="row">
            <span>Website:</span>
            <span>{{ carrier.website }}</span>
          </div>
          <div class="row">
            <span>Address:</span>
            <span>{{ carrier.address.formatted_address }}</span>
          </div>
          <div class="row">
            <span>Number of employees:</span>
            <span>{{ carrier.address.employees }}</span>
          </div>
          <div class="row">
            <span>Number of vehicles:</span>
            <span>{{ carrier.address.vehicles }}</span>
          </div>
          <div class="row">
            <span>Company name:</span>
            <span>{{ carrier.company }}</span>
          </div>
          <div class="row">
            <span>Established year:</span>
            <span>{{ carrier.year_established }}</span>
          </div>
          <div class="row">
            <span>More details:</span>
            <span>{{ carrier.detail }}</span>
          </div>
          <div class="row">
            <span>Insurance paper:</span>
            <span>Not attached</span>
          </div>
          <div class="row">
            <span>Business license:</span>
            <span>Not attached</span>
          </div>
        </div>
      </div>
    </md-card-content>
    <md-card-actions v-if="carrier">
      <md-button :to="{ path: 'edit/' + 1 }" class="md-primary">
        Edit
        <md-tooltip>Edit profile</md-tooltip>
      </md-button>
    </md-card-actions>
  </md-card>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
  name: "CarrierDetails",
  data: () => ({
    carrier: null,
    hasCompany: false,
    temp: {
      me: null,
      country: null,
    },
  }),
  methods: {
    ...mapActions({
      tempData: "shared/tempData",
    }),
    async get() {
      await axios
        .get("carrier/details")
        .then((res) => {
          console.log("carrier: ", res.data);
          this.carrier = res.data;
          this.temp.me = this.carrier.id;
          this.tempData(this.temp).then((res) => {});
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },

  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .md-card-content {
    padding: 20px;
    .row {
      display: flex;
      > :first-child {
        min-width: 200px;
      }
    }
  }
  .md-card-actions {
    display: flex;
    justify-content: flex-start;
  }
}
</style>
