<template>
  <div>
    <b-sidebar
      v-model="isSidebarOpen"
      id="sidebar-backdrop"
      ref="sidebar"
      :backdrop-variant="variant"
      backdrop
      shadow
      pr-0
      pl-0
    >
      <div class="px-0 py-0">
        <CarrierMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-if="authenticated && user.role[0].name === 'mover'"
        />
        <ShipperMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-else-if="authenticated && user.role[0].name === 'customer'"
        />
        <AdminMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-else-if="authenticated && user.role[0].name === 'admin'"
        />
        <SupportMenu
          v-on:hideSideMenu="menuVisible = !menuVisible"
          v-else-if="authenticated && user.role[0].name === 'support'"
        />
        <HomeMenu v-else v-on:hideSideMenu="menuVisible = !menuVisible" />
      </div>
    </b-sidebar>
    <div class="content">
      <router-view v-on:togal-menu="isSidebarOpen = true"></router-view>
    </div>
  </div>
</template>
<script>
import HomeMenu from "./HomeMenu";
import Header from "../shared/Header";
import CarrierMenu from "./carrier/CarrierMenu";
import ShipperMenu from "./shipper/ShipperMenu";
import AdminMenu from "../backend/AdminSideMenu";
import SupportMenu from "../backend/SupportSideMenu";
import { mapGetters, mapActions } from "vuex";
export default {
  name: "Home",
  components: {
    AdminMenu,
    SupportMenu,
    HomeMenu,
    CarrierMenu,
    ShipperMenu,
    Header,
  },
  data: () => ({
    variant: "dark",
    variants: ["white"],
    isSidebarOpen: false,
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

  methods: {},
};
</script>

<style lang="scss" scoped>
@media only screen and (max-width: 600px) {
}
</style>
