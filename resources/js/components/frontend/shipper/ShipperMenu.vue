<template>
  <div>
    <md-toolbar md-elevation="0" v-if="authenticated" class="custom-toolbar">
      <div class="row" v-if="authenticated">
        <div class="avatar" @click="profile()">
          <img :src="'/images/pub/' + user.avatar" width="80" alt="" />
        </div>
        <div class="break"></div>
        <div class="text">
          <div class="name md-list-item-text">{{ user.name }}</div>
          <div class="email">{{ formatPhone(user.phone) }}</div>
        </div>
      </div>
    </md-toolbar>
    <md-divider></md-divider>
    <md-list>
      <md-list-item @click="navigate('/')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'home',
          }"
          >Home</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/help/shipper')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'help',
          }"
          >Help</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/shipper/profile')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'shipper-details',
          }"
          >Profile</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/shipper/orders')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'order-list',
          }"
          >Orders</span
        >
      </md-list-item>
      <md-list-item @click="navigate('/shipper/payments')">
        <span
          class="md-list-item-text"
          v-bind:class="{
            active: $route.name == 'payments',
          }"
          >Payment</span
        >
      </md-list-item>
      <md-divider></md-divider>
      <md-list-item @click="logout('/')">
        <span class="md-list-item-text">Signout</span>
      </md-list-item>
    </md-list>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Notifications from "../../shared/Notifications";
import USPhone from "../services/USPhone";
export default {
  name: "WebMenu",
  components: {
    Notifications,
  },
  data: () => ({
    expandSingle: false,
  }),
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
    profile() {
      this.$router.push("/shipper/account");
      this.$emit("hideSideMenu");
    },
    logout() {
      this.signOutAction().then(() => {
        this.$router.push("/");
      });
      this.$emit("hideSideMenu");
    },

    navigate(path) {
      this.$router.push(path);
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
  .md-list-item-text {
    font-weight: 500;
  }
}
.custom-toolbar {
  background: #fff !important;
  height: 155px;
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
    .md-button {
      font-size: 20px !important;
    }
  }
}
</style>
