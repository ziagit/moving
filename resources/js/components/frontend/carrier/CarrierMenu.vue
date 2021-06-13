<template>
  <div>
    <md-toolbar md-elevation="0" v-if="authenticated" class="custom-toolbar">
      <div class="row">
        <div class="avatar" @click="profile()">
          <img :src="'/images/pub/' + user.avatar" width="80" alt="" />
        </div>
        <div class="break"></div>
        <div class="text" v-if="details">
          <div class="name md-list-item-text">{{ details.company }}</div>
          <div class="email">
            <star-rating
              v-model="details.votes"
              :star-size="11"
              :read-only="true"
              :show-rating="false"
            />
          </div>
        </div>
      </div>
    </md-toolbar>
    <md-divider></md-divider>
    <md-list>
      <div v-if="authenticated">
        <md-list-item @click="navigate('/carrier/inbox')">
          <span class="md-list-item-text">Notifications</span>
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
            >Account</span
          >
        </md-list-item>

        <md-list-item @click="navigate('/carrier/history')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'jobs',
            }"
            >Jobs</span
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
        <md-list-item @click="navigate('/carrier/payments')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'details',
            }"
            >Wallet</span
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

        <md-list-item @click="navigate('/help/' + 'carrier')">
          <span
            class="md-list-item-text"
            v-bind:class="{
              active: $route.name == 'help',
            }"
            >Help</span
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
.md-list {
  padding: 0 !important;
}
.md-list-item-text {
  font-weight: 500;
}
.custom-toolbar {
  height: 155px;
  display: flex;
  justify-content: center;
  background: #fff !important;
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
