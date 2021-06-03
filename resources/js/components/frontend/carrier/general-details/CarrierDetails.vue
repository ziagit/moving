<template>
  <div class="account" v-if="carrier">
    <edit-account v-if="myTogal" :user="carrier.user" v-on:close-child="close" />
    <md-card v-else>
      <md-card-header><span class="md-title">Account</span></md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div>
          <div class="row">
            <span>Email:</span>
            <span>{{ carrier.user.email }}</span>
          </div>
          <div class="row">
            <span>Password:</span>
            <span>********</span>
          </div>
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button @click="editAccount()" class="md-primary">
          Edit
          <md-tooltip>Edit profile</md-tooltip>
        </md-button>
      </md-card-actions>
    </md-card>
    <div class="break"></div>
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
      <md-card-actions v-if="carrier">
        <md-button @click="edit(carrier.id)" class="md-primary"> Edit </md-button>
      </md-card-actions>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
import EditAccount from "./EditAccount.vue";
export default {
  components: { EditAccount },
  name: "CarrierDetails",
  data: () => ({
    carrier: null,
    myTogal: false,
  }),

  methods: {
    async get() {
      await axios
        .get("carrier/details")
        .then((res) => {
          this.carrier = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    edit(id) {
      this.$router.push("edit/" + id);
    },
    close() {
      this.myTogal = false;
      this.get();
    },
    editAccount() {
      this.myTogal = true;
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
    .md-card-actions {
      display: flex;
      justify-content: flex-start;
    }
  }
}
.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
