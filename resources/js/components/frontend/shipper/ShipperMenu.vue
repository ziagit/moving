<template>
  <div>
    <div v-if="authenticated" class="custom-toolbar">
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
        <p class="mb-0">
          {{ formatPhone(user.phone) }}
        </p>
      </div>
    </div>
    <div class="line"></div>
    <b-list-group>
      <b-list-group-item class="border-0" button @click="navigate('/')">
        <span
          v-bind:class="{
            active: $route.name == 'home',
          }"
          >Home</span
        >
      </b-list-group-item>

      <b-list-group-item class="border-0" button @click="navigate('/shipper/profile')">
        <span
          v-bind:class="{
            active: $route.name == 'shipper-details',
          }"
          >Profile</span
        >
      </b-list-group-item>
      <b-list-group-item class="border-0" button @click="navigate('/shipper/orders')">
        <span
          v-bind:class="{
            active: $route.name == 'order-list',
          }"
          >Orders</span
        >
      </b-list-group-item>
      <b-list-group-item class="border-0" button @click="navigate('/shipper/payments')">
        <span
          v-bind:class="{
            active: $route.name == 'payments',
          }"
          >Payment</span
        >
      </b-list-group-item>
      <b-list-group-item class="border-0" button @click="navigate('/help')">
        <span
          v-bind:class="{
            active: $route.name == 'help',
          }"
          >Help</span
        >
      </b-list-group-item>
      <div class="line"></div>
      <b-list-group-item class="border-0" button @click="logout('/')">
        <span>Signout</span>
      </b-list-group-item>
    </b-list-group>
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
.custom-toolbar {
  text-align: center;
}
</style>
