<template>
  <div>
    <div class="account mb-5" v-if="carrier">
      <edit-account v-if="myTogal" :user="carrier.user" v-on:close-child="close" />
      <b-card v-else header="Account" class="border-0 shadow text-left mb-4">
        <div class="px-3">
          <div class="row">
            <span class="col-4 text-left">Email:</span>
            <span class="col-8 text-left">{{ carrier.user.email }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Password:</span>
            <span class="col-8 text-left">********</span>
          </div>
        </div>

        <div class="text-right">
          <b-button @click="editAccount()" variant="primary"> Edit </b-button>
        </div>
      </b-card>
      <b-card header="Profile" class="border-0 shadow text-left">
        <div v-if="carrier" class="px-3">
          <div class="row">
            <span class="col-4 text-left">First name:</span>
            <span class="col-8 text-left">{{ carrier.first_name }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Last name:</span>
            <span class="col-8 text-left">{{ carrier.last_name }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Phone:</span>
            <span class="col-8 text-left">{{ carrier.user.phone }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Website:</span>
            <span class="col-8 text-left">{{ carrier.website }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Address:</span>
            <span class="col-8 text-left">{{ carrier.address.formatted_address }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Number of employees:</span>
            <span class="col-8 text-left">{{ carrier.employees }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Number of vehicles:</span>
            <span class="col-8 text-left">{{ carrier.vehicles }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left"
              >Rate per hour for two movers and a vehicle:</span
            >
            <span class="col-8 text-left">${{ carrier.hourly_rate }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Company name:</span>
            <span class="col-8 text-left">{{ carrier.company }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Established year:</span>
            <span class="col-8 text-left">{{ carrier.year_established }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">More details:</span>
            <span class="col-8 text-left">{{ carrier.detail }}</span>
          </div>
          <div class="row">
            <span class="col-4 text-left">Insurance paper:</span>
            <span class="col-8 text-left" v-if="carrier.insurance_papers == 'undefined'"
              >Not attached</span
            >
            <a
              class="col-8 text-left"
              v-else
              :href="'/images/pub/' + carrier.insurance_papers"
              target="_blank"
              ><b-icon icon="download"></b-icon
            ></a>
          </div>
          <div class="row">
            <span class="col-4 text-left">Business license:</span>
            <span class="col-8 text-left" v-if="carrier.business_license == 'undefined'"
              >Not attached</span
            >
            <a
              class="col-8 text-left"
              v-else
              :href="'/images/pub/' + carrier.insurance_papers"
              target="_blank"
              ><b-icon icon="download"></b-icon
            ></a>
          </div>
        </div>
        <div class="text-right" v-if="carrier">
          <b-button @click="edit(carrier.id)" variant="primary"> Edit </b-button>
        </div>
      </b-card>
    </div>
    <div v-else class="d-flex justify-content-center">
      <b-spinner variant="primary"></b-spinner>
    </div>
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
          console.log("hi", res.data);
          if (res.data.first_name == undefined) {
            this.$router.push("add");
          } else {
            this.carrier = res.data;
          }
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
.download {
  cursor: pointer;
}
</style>
