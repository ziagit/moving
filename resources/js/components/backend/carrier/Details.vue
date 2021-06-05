<template>
  <div class="account">
    <Account v-if="carrier" :user="carrier.user.id" />
    <div class="break"></div>
    <Edit
      :carrier="carrier"
      v-on:refresh="refresh"
      v-on:close-it="detailsTogal = false"
      v-if="detailsTogal"
    />
    <md-card v-else>
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
              <span>Phone:</span>
              <span>{{ carrier.user.phone }}</span>
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
              <span>{{ carrier.employees }}</span>
            </div>
            <div class="row">
              <span>Number of vehicles:</span>
              <span>{{ carrier.vehicles }}</span>
            </div>
            <div class="row">
              <span>Rate per hour for two movers and a vehicle:</span>
              <span>${{ carrier.hourly_rate }}</span>
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
      <md-card-actions>
        <md-button @click="detailsTogal = true" class="md-primary"> Edit </md-button>
      </md-card-actions>
    </md-card>
  </div>
</template>
<script>
import Edit from "./Edit";
import EditAccount from "./account/Edit";
import Account from "./account/Account";
export default {
  name: "Details",
  components: {
    Edit,
    EditAccount,
    Account,
  },
  data: () => ({
    carrier: null,
    detailsTogal: false,
  }),

  methods: {
    async get() {
      await axios
        .get("admin/carriers/" + this.$route.params.id)
        .then((res) => {
          this.carrier = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    refresh() {
      this.detailsTogal = false;
      this.get();
    },
  },

  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.account {
  padding-bottom: 30px;
  .md-card {
    text-align: left;
    .md-card-content {
      padding: 20px;
      .row {
        display: flex;
        > :first-child {
          width: 200px;
        }
      }
    }
  }
}
</style>
