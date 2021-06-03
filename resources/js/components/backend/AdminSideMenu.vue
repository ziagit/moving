<template>
  <div>
    <md-toolbar md-elevation="0" v-if="authenticated" class="custom-toolbar">
      <div class="row" v-if="authenticated">
        <div class="avatar" @click="profile()">
          <img :src="'/images/pub/' + user.avatar" width="80" alt="" />
        </div>
        <div class="break"></div>
        <div class="text">
          <div class="name md-title">{{ user.name }}</div>
          <div class="email">{{ formatPhone(user.phone) }}</div>
        </div>
      </div>
    </md-toolbar>
    <md-divider></md-divider>
    <md-list :md-expand-single="expandSingle">
      <md-list-item @click="hideMenu('inbox')">
        <span class="md-list-item-text">Notifications</span>
      </md-list-item>
      <md-list-item @click="hideMenu('dashboard')">
        <span class="md-list-item-text">Dashboard</span>
      </md-list-item>
      <md-list-item md-expand :md-expanded.sync="expandLookups">
        <span class="md-list-item-text">Lookups</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" @click="hideMenu('countries')"
            >Countries</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('states')">States</md-list-item>
          <md-list-item class="md-inset" @click="hideMenu('cities')">Cities</md-list-item>
          <md-list-item class="md-inset" @click="hideMenu('moving-types')"
            >Moving types</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('moving-sizes')"
            >Moving sizes</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('office-sizes')"
            >Office sizes</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('number-of-movers')"
            >Number of movers</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('moving-few-items')"
            >Few items</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('supplies')"
            >Supplies</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('vehicles')"
            >Vehicles</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('constans')"
            >Tax +</md-list-item
          >
        </md-list>
      </md-list-item>

      <md-list-item md-expand :md-expanded.sync="expandCarriers">
        <span class="md-list-item-text">Carriers</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" @click="hideMenu('carriers-account')"
            >Carriers</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('carriers')"
            >Profiles</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('rates')">Rates</md-list-item>
          <md-list-item class="md-inset" @click="hideMenu('jobs')">Jobs</md-list-item>
        </md-list>
      </md-list-item>
      <md-list-item md-expand :md-expanded.sync="expandShippers">
        <span class="md-list-item-text">Customers</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" @click="hideMenu('shippers-account')"
            >Customers</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('shippers')"
            >Profiles</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('orders')">Orders</md-list-item>
        </md-list>
      </md-list-item>

      <md-list-item @click="hideMenu('users')">
        <span class="md-list-item-text">Users</span>
      </md-list-item>
      <md-list-item md-expand :md-expanded.sync="expandCompany">
        <span class="md-list-item-text">Pages</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" @click="hideMenu('about')">About</md-list-item>

          <md-list-item class="md-inset" @click="hideMenu('terms')">Terms</md-list-item>
          <md-list-item class="md-inset" @click="hideMenu('privacy')"
            >Privacy</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('shipper-help')"
            >Customer</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('carrier-help')"
            >Carrier</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('help')">Help</md-list-item>
          <md-list-item class="md-inset" @click="hideMenu('carrier-faq')"
            >Carrier FAQ</md-list-item
          >
          <md-list-item class="md-inset" @click="hideMenu('shipper-faq')"
            >Customer FAQ</md-list-item
          >
        </md-list>
      </md-list-item>

      <md-list-item md-expand :md-expanded.sync="expandFinance">
        <span class="md-list-item-text">Finance</span>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" @click="hideMenu('finances')"
            >Earnings</md-list-item
          >
        </md-list>
        <md-list slot="md-expand">
          <md-list-item class="md-inset" @click="hideMenu('finances')"
            >Payouts</md-list-item
          >
        </md-list>
      </md-list-item>
      <div v-if="authenticated">
        <md-divider></md-divider>
        <md-list-item @click="signOut()">
          <span class="md-list-item-text">Logout</span>
        </md-list-item>
      </div>
    </md-list>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Notifications from "../shared/Notifications";
import USPhone from "../frontend/services/USPhone";
export default {
  name: "AdminMenu",
  components: {
    Notifications,
  },
  data: () => ({
    expandCompany: false,
    expandShippers: false,
    expandLookups: false,
    expandFinance: false,
    expandCarriers: false,
    expandSingle: false,
  }),
  created() {},
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  methods: {
    togal() {
      this.$emit("hideSideMenu");
    },
    ...mapActions({
      signOutAction: "auth/signOut",
      setNotification: "shared/setNotification",
    }),
    signOut() {
      this.signOutAction().then(() => {
        this.$router.push("/");
      });
      this.$emit("hideSideMenu");
    },

    profile() {
      this.$router.push("/admin/dashboard");
      this.$emit("hideSideMenu");
    },
    hideMenu(path) {
      this.$router.push("/admin/" + path);
      this.$emit("hideSideMenu");
    },
    formatPhone(phone) {
      return USPhone.formatPhone(phone);
    },
  },
};
</script>

<style lang="scss" scoped>
.active {
  color: #ffa500 !important;
}
.md-list {
  padding: 0 !important;
}
.md-list-item-text {
  font-weight: 500;
}
.custom-toolbar {
  background: #fff !important;
  height: 155px;
  display: flex;
  justify-content: center;
  .row {
    width: 100%;
    .avatar {
      margin: auto;
      text-align: center;
      align-items: center;
      display: flex;
      justify-content: center;
      cursor: pointer;
    }
    .text {
      text-align: left;
      .name {
        font-weight: 600;
      }
      .email {
        font-size: 11px;
      }
    }
  }
}
</style>
