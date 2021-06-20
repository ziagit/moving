<template>
  <div class="container">
    <Account v-if="carrier" :user="carrier.user.id" />
    <div class="break"></div>
    <Edit
      :carrier="carrier"
      v-on:refresh="refresh"
      v-on:close-it="detailsTogal = false"
      v-if="detailsTogal"
    />
    <b-card v-else header="Profile Details" class="shadow border-0">
      <b-button variant="light" @click="$router.push('/admin/carriers')" class="add-btn">
        <b-icon icon="x">close</b-icon>
      </b-button>
      <div v-if="carrier">
        <div class="row">
          <span class="col-3">First name:</span>
          <span class="col-6">{{ carrier.first_name }}</span>
        </div>
        <div class="row">
          <span class="col-3">Last name:</span>
          <span class="col-6">{{ carrier.last_name }}</span>
        </div>
        <div class="row">
          <span class="col-3">Phone:</span>
          <span class="col-6">{{ carrier.user.phone }}</span>
        </div>
        <div class="row">
          <span class="col-3">Website:</span>
          <span class="col-6">{{ carrier.website }}</span>
        </div>
        <div class="row">
          <span class="col-3">Address:</span>
          <span class="col-6">{{ carrier.address.formatted_address }}</span>
        </div>
        <div class="row">
          <span class="col-3">Number of employees:</span>
          <span class="col-6">{{ carrier.employees }}</span>
        </div>
        <div class="row">
          <span class="col-3">Number of vehicles:</span>
          <span class="col-6">{{ carrier.vehicles }}</span>
        </div>
        <div class="row">
          <span class="col-3">Rate per hour for two movers and a vehicle:</span>
          <span class="col-6">${{ carrier.hourly_rate }}</span>
        </div>
        <div class="row">
          <span class="col-3">Company name:</span>
          <span class="col-6">{{ carrier.company }}</span>
        </div>
        <div class="row">
          <span class="col-3">Established year:</span>
          <span class="col-6">{{ carrier.year_established }}</span>
        </div>
        <div class="row">
          <span class="col-3">More details:</span>
          <span class="col-6">{{ carrier.detail }}</span>
        </div>
        <div class="row">
          <span class="col-3">Insurance paper:</span>
          <span class="col-6">Not attached</span>
        </div>
        <div class="row">
          <span class="col-3">Business license:</span>
          <span class="col-6">Not attached</span>
        </div>
      </div>
      <div class="text-right mt-3">
        <b-button @click="detailsTogal = true" variant="primary"> Edit </b-button>
      </div>
    </b-card>
    <div v-if="carrier" class="text-right mt-3 mb-3">
      <b-button
        variant="success"
        v-if="carrier.user.status == 'Active'"
        @click="edit('Locked')"
        ><b-icon icon="lock"></b-icon
      ></b-button>
      <b-button v-else variant="success" @click="edit('Active')"
        ><b-icon icon="unlock"></b-icon
      ></b-button>
      <b-button variant="danger" @click="edit('Deleted')"
        ><b-icon icon="trash"></b-icon
      ></b-button>
    </div>
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
    lockTogal: false,
  }),

  methods: {
    async get() {
      await axios
        .get("admin/carriers/" + this.$route.params.id)
        .then((res) => {
          this.carrier = res.data;
          console.log("ress", res.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    edit(status) {
      this.$bvModal
        .msgBoxConfirm("Do you want this account to be " + status + "?")
        .then((value) => {
          if (value) {
            this.confirm(status);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    refresh() {
      this.detailsTogal = false;
      this.get();
    },
    confirm(status) {
      console.log("xxxxxxx", this.carrier.user.id);
      if (status == "Deleted") {
        axios
          .delete("admin/users/" + this.user)
          .then((res) => {
            this.router.push("/admin/carriers");
          })
          .catch((err) => {
            console.log("Error: ", err);
          });
      } else {
        axios
          .put("admin/users/lock/" + this.carrier.user.id, { status: status })
          .then((res) => {
            this.get();
          })
          .catch((err) => {
            console.log("Error: ", err);
          });
      }
    },
  },

  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.container {
  min-height: calc(100vh - 50px);

  .add-btn {
    position: absolute;
    top: 1px;
    right: 1px;
  }
}
</style>
