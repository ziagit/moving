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
      <div class="text" v-if="details">
        <p class="mb-0">{{ details.company }}</p>
        <div>
          <div></div>
          <b-form-rating
            variant="warning"
            id="rating-md-no-border"
            readonly
            v-model="details.votes"
            no-border
            inline
          ></b-form-rating>
          <div></div>
        </div>
      </div>
    </div>
    <div class="line"></div>
    <b-list-group>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/inbox')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'inbox',
          }"
        >
          Notifications
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/dashboard')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'dashboard',
          }"
        >
          Dashboard
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/profile')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'carrier-details',
          }"
        >
          Account
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/history')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'jobs',
          }"
        >
          Jobs
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/earnings')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'earning-list',
          }"
        >
          Earnings
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/payments')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'details',
          }"
        >
          Wallet
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/carrier/calendar')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'calendar',
          }"
        >
          Calendar
        </span>
      </b-list-group-item>
      <b-list-group-item button class="border-0" @click="navigate('/help')">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'help',
          }"
        >
          Help
        </span>
      </b-list-group-item>
      <div class="line"></div>
      <b-list-group-item button class="border-0" @click="signOut()">
        <span
          class="mb-0"
          v-bind:class="{
            active: $route.name == 'logout',
          }"
        >
          Signout
        </span>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>
<script>
import axios from "axios";
import StarRating from "vue-star-rating";
import { mapGetters, mapActions } from "vuex";
import USPhone from "../services/USPhone";
export default {
  name: "WebMenu",
  components: {
    StarRating,
  },
  data: () => ({
    menuVisible: false,
    details: null,
  }),
  created() {
    this.getDetails();
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
    formatPhone(phone) {
      return USPhone.formatPhone(phone);
    },
    getDetails() {
      axios.get("carrier/details").then((res) => {
        this.details = res.data;
      });
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
