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
          <SideMenu />
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
import SideMenu from "./AdminSideMenu";
import Footer from "../shared/Footer";
import Header from "../shared/Header";
export default {
  name: "Admin",
  components: {
    Header,
    Footer,
    SideMenu,
  },
  data: () => ({
    variant: "dark",
    variants: ["white"],
    isSidebarOpen: false,
  }),
};
</script>

<style lang="scss"></style>
