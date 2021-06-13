<template>
  <div class="account">
    <md-dialog-confirm
      :md-active.sync="lockTogal"
      md-title="Confirmation"
      :md-content="confirmation_text"
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />
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
        <md-button to="/admin/carriers" class="md-icon-button add-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
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
    <div class="delete">
      <md-button
        v-if="carrier.user.status == 'Active'"
        class="md-primary md-fab md-raised"
        @click="edit('Locked')"
        ><md-icon>lock</md-icon></md-button
      >
      <md-button v-else class="md-primary md-fab md-raised" @click="edit('Active')"
        ><md-icon>lock_open</md-icon></md-button
      >
      <md-button class="md-primary md-fab md-raised" @click="edit('Deleted')"
        ><md-icon>delete</md-icon></md-button
      >
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
    confirmation_text: null,
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
      this.confirmation_text = "Do you want this account to be " + status + "?";
      this.status = status;
      this.lockTogal = true;
    },
    refresh() {
      this.detailsTogal = false;
      this.get();
    },
    confirm() {
      if (this.status == "Deleted") {
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
          .put("admin/users/lock/" + this.user, { status: this.status })
          .then((res) => {
            this.get();
          })
          .catch((err) => {
            console.log("Error: ", err);
          });
      }
    },
    cancel() {},
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
    .add-btn {
      position: absolute;
      top: 1px;
      right: 1px;
    }
  }
  .delete {
    margin: 30px;
    text-align: right;
  }
}
</style>
