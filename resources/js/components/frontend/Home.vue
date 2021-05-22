<template>
  <div class="home">
    <md-app md-mode="reveal">
      <md-app-drawer :md-active.sync="menuVisible">
        <AdminSideMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-if="authenticated && user.role[0].name === 'admin'"
        />
        <CarrierMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-else-if="authenticated && user.role[0].name === 'mover'"
        />
        <ShipperMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-else-if="authenticated && user.role[0].name === 'customer'"
        />
        <HomeMenu v-else v-on:hideSideMenu="menuVisible = !menuVisible" />
      </md-app-drawer>
      <md-app-content>
        <router-view v-on:togal-menu="menuVisible = !menuVisible"></router-view>
      </md-app-content>
    </md-app>
  </div>
</template>

<script>
import AdminSideMenu from "../backend/AdminSideMenu";
import HomeMenu from "./HomeMenu";
import CarrierMenu from "./carrier/CarrierMenu";
import ShipperMenu from "./shipper/ShipperMenu";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Home",
  components: {
    HomeMenu,
    AdminSideMenu,
    CarrierMenu,
    ShipperMenu,
  },
  data: () => ({
    menuVisible: false,
    activeRoute: "home",
    notifications: [],
    notificationsLength: 0,
    windowWidth: window.innerWidth,
  }),

  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },

  methods: {
    profile(path) {
      this.$router.push(path);
      this.menuVisible = false;
    },
    login(path) {
      this.$router.push(path);
      this.menuVisible = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.md-menu-content {
  border-radius: 7px;

  .md-menu-content-container {
    border-radius: 7px !important;

    .md-list {
      border-radius: 7px !important;
    }
  }
}

.home {
  height: 100%;
  .md-app {
    height: 100%;
    .md-app-toolbar {
      background: #2d2e2e;
      box-shadow: none;
      color: #fff !important;
      border-bottom: #6b6b6b3b solid 1px;
      .md-title {
        color: #fff;
      }
      .md-button,
      .md-icon-button,
      .md-icon {
        color: #fff;
      }
    }
  }

  // Demo purposes only
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
    z-index: 10;
  }

  .md-app-content {
    //background: #f0f2f5;
    background: #fff;
    /* background-image: linear-gradient(#fff, #F0F2F5); */
    padding: 0;
    /* background-image: linear-gradient(#2f2f65, #2a6ab3); */
    /* padding-bottom: 20px; */
  }

  .live-chat {
    position: fixed;
    right: 10px;
    bottom: 10px;
  }

  .navigation {
    display: flex;
  }
}

.menu-head {
  text-align: center;
  margin-bottom: 18px;

  .md-avatar {
    margin: 7px;
    background: #f0f2f5;
  }
}

@media only screen and (max-width: 600px) {
  .logo {
    font-size: 16px;
    padding: 0;
    margin: 0 !important;

    img {
      width: 20px;
    }
  }
}
</style>
