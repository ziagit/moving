<template>
  <div>
    <div v-if="authenticated" class="text-center">
      <b-avatar
        button
        :src="'/images/pub/' + user.avatar"
        size="5rem"
        @click="profile()"
        class="mt-3 mb-3"
      ></b-avatar>
      <div class="text" v-if="user">
        <p class="mb-0">
          <b>{{ user.name }}</b>
        </p>
        <p>{{ user.email }}</p>
      </div>
    </div>
    <div class="line"></div>
    <ul class="o-ul">
      <li @click="hideMenu('inbox')"><span>Notifications</span></li>
      <li @click="hideMenu('dashboard')"><span>Dashboard</span></li>
      <li @click="lookupTogal = !lookupTogal">
        <div class="childer">
          <span>Lookups</span>
          <b-icon v-if="!lookupTogal" icon="chevron-right"></b-icon>
          <b-icon v-else icon="chevron-down"> </b-icon>
        </div>
        <ul v-show="lookupTogal" class="i-ul">
          <li @click="hideMenu('countries')"><span>Countries</span></li>
          <li @click="hideMenu('states')"><span>States</span></li>
          <li @click="hideMenu('cities')"><span>Cities</span></li>
          <li @click="hideMenu('moving-types')"><span>Moving types</span></li>
          <li @click="hideMenu('office-sizes')"><span>Office sizes</span></li>
          <li @click="hideMenu('number-of-movers')"><span>Number of movers</span></li>
          <li @click="hideMenu('moving-few-items')"><span>Few items</span></li>
          <li @click="hideMenu('supplies')"><span>Supplies</span></li>
          <li @click="hideMenu('vehicles')"><span>Vehicles</span></li>
          <li @click="hideMenu('tax')"><span>Fees & Taxes</span></li>
        </ul>
      </li>
      <li @click="hideMenu('carriers')"><span>Movers</span></li>
      <li @click="hideMenu('shippers')"><span>Customers</span></li>
      <li @click="hideMenu('orders')"><span>Orders</span></li>
      <li @click="hideMenu('users')"><span>Users</span></li>
      <li @click="financeTogal = !financeTogal">
        <div class="childer">
          <span><span>Finances</span></span>
          <b-icon v-if="!financeTogal" icon="chevron-right"></b-icon>
          <b-icon v-else icon="chevron-down"> </b-icon>
        </div>
        <ul v-show="financeTogal" class="i-ul">
          <li @click="hideMenu('revenue')"><span>Revenue</span></li>
          <li @click="hideMenu('unpaid-jobs')"><span>Unpaid jobs</span></li>
          <li @click="hideMenu('paid-jobs')"><span>Paid jobs</span></li>
          <li @click="hideMenu('payouts')"><span>Payouts</span></li>
          <li @click="hideMenu('refunds')"><span>Refunds</span></li>
        </ul>
      </li>
      <li @click="reportTogal = !reportTogal">
        <div class="childer">
          <span><span>Reports</span></span>
          <b-icon v-if="!reportTogal" icon="chevron-right"></b-icon>
          <b-icon v-else icon="chevron-down"> </b-icon>
        </div>
        <ul v-show="reportTogal" class="i-ul">
          <li @click="hideMenu('reports/sales-reports')"><span>Sales reports</span></li>
          <li @click="hideMenu('reports/financial-reports')">
            <span>Financial reports</span>
          </li>
        </ul>
      </li>
      <li @click="pageTogal = !pageTogal">
        <div class="childer">
          <span><span>Pages</span></span>
          <b-icon v-if="!pageTogal" icon="chevron-right"></b-icon>
          <b-icon v-else icon="chevron-down"> </b-icon>
        </div>
        <ul v-show="pageTogal" class="i-ul">
          <li @click="hideMenu('about')"><span>What is TingsApp</span></li>
          <li @click="hideMenu('how-it-works')"><span>How it works</span></li>
          <li @click="hideMenu('carrier-faq')"><span>Mover </span></li>
          <li @click="hideMenu('shipper-faq')"><span>Customer </span></li>
          <li @click="hideMenu('terms')"><span>Terms</span></li>
          <li @click="hideMenu('privacy')"><span>Privacy</span></li>
          <li @click="hideMenu('legals')"><span>Legals</span></li>
        </ul>
      </li>
      <div class="line"></div>
      <li @click="signOut()"><span>Logout</span></li>
    </ul>
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
    lookupTogal: false,
    financeTogal: false,
    reportTogal: false,
    pageTogal: false,
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
      this.$router.push("/admin/account");
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
.o-ul {
  margin: 0;
  padding: 0;
  li {
    list-style-type: none;
    padding: 8px 8px 8px 18px;
    cursor: pointer;
  }

  .childer {
    display: flex;
    justify-content: space-between;
  }
  span {
    margin: 0;
    padding: 0;
  }
}
.active {
  color: #ffa500 !important;
}
.o-ul > li:hover {
  background: #ddd;
}
.o-ul li ul li:hover {
  background: rgb(241, 240, 240);
}
</style>
