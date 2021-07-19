<template>
  <div class="admin">
    <div>
      <Header v-on:togal-menu="isSidebarOpen = true" class="no-print" />
      <b-sidebar
        v-model="isSidebarOpen"
        id="sidebar-backdrop"
        :backdrop-variant="variant"
        backdrop
        shadow
      >
        <div class="px-3 py-2">
          <Admin v-if="user.role[0].name == 'admin'" />
          <SupportMenu v-else />
        </div>
      </b-sidebar>
    </div>
    <div class="content">
      <router-view></router-view>
    </div>
    <Footer class="no-print" />
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import AdminMenu from "./AdminSideMenu";
import SupportMenu from "./SupportSideMenu";
import Footer from "../shared/Footer";
import Header from "../shared/Header";
export default {
  name: "Admin",
  components: {
    Header,
    Footer,
    AdminMenu,
    SupportMenu,
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  data: () => ({
    variant: "dark",
    variants: ["white"],
    isSidebarOpen: false,
  }),
};
</script>

<style lang="scss"></style>
