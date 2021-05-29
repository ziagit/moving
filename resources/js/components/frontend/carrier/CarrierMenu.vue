<template>
  <div>
    <md-toolbar md-elevation="0" v-if="authenticated" class="custom-toolbar">
      <div class="row" v-if="authenticated">
        <div class="img" @click="profile()"></div>
        <div class="break"></div>
        <div class="text">
          <div class="name md-list-item-text">{{ user.name }}</div>
          <div class="email">{{ user.phone }}</div>
        </div>
      </div>
    </md-toolbar>
    <md-list>
      <div v-if="authenticated">
        <md-list-item @click="navigate('/help')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'help',
            }"
            >Help</span
          >
        </md-list-item>
        <md-list-item @click="navigate('/carrier/dashboard')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'dashboard',
            }"
            >Dashboard</span
          >
        </md-list-item>
        <md-list-item @click="navigate('/carrier/profile')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'carrier-details',
            }"
            >Profile</span
          >
        </md-list-item>

        <md-list-item @click="navigate('/carrier/rates')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'rate-list',
            }"
            >Rates</span
          >
        </md-list-item>
        <md-list-item @click="navigate('/carrier/history')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'jobs',
            }"
            >Job History</span
          >
        </md-list-item>
        <md-list-item @click="navigate('/carrier/earnings')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'earning-list',
            }"
            >Earnings</span
          >
        </md-list-item>
        <md-list-item @click="navigate('/carrier/calendar')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'calendar',
            }"
            >Calendar</span
          >
        </md-list-item>
        <md-list-item @click="navigate('/carrier/payments')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'details',
            }"
            >Payments</span
          >
        </md-list-item>
      </div>
      <md-divider></md-divider>
      <md-list-item @click="signOut()" v-if="authenticated">
        <span class="md-list-item-text">Signout</span>
      </md-list-item>
    </md-list>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Notifications from "../../shared/Notifications";
export default {
  name: "WebMenu",
  components: {
    Notifications,
  },
  data: () => ({
    menuVisible: false,
  }),
  created() {
    this.getNotifications();
  },
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
    profile() {
      this.$router.push("/carrier/account");
      this.$emit("hideSideMenu");
    },
    ...mapActions({
      signOutAction: "auth/signOut",
      setNotification: "shared/setNotification",
    }),
    getNotifications() {
      if (this.authenticated) {
        this.notifications = this.user.notifications;
        Echo.private("App.User." + this.user.id).notification((res) => {
          this.notifications.push(res.notification);
          console.log("notifications: in admin: ", this.notifications);
        });
      }
    },
    signOut() {
      this.signOutAction().then(() => {
        this.$router.push("/");
      });
      this.$emit("hideSideMenu");
    },
    login() {
      this.$router.push("/login");
      this.$emit("hideSideMenu");
    },
    navigate(path) {
      this.$router.push(path);
      this.$emit("hideSideMenu");
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
  background: #ffa500;
  height: 155px;
  display: flex;
  justify-content: center;
  .row {
    width: 100%;
    .img {
      margin: auto;
      height: 68px;
      width: 68px;
      text-align: center;
      align-items: center;
      display: flex;
      border-radius: 50px;
      border: solid 1px #3333334d;
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
