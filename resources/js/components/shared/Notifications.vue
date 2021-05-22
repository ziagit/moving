<template>
  <div>
    <md-badge class="md-danger" :md-content="notifications.length" md-dense>
      <md-menu>
        <md-button class="md-icon-button" md-menu-trigger>
          <md-icon>notifications</md-icon>
        </md-button>
        <md-menu-content>
          <md-menu-item
            v-for="(notification, index) in notifications"
            :key="index"
            @click="notificationDetails(notification)"
          >
            <span> {{ index + 1 }}. New job</span>
          </md-menu-item>
        </md-menu-content>
      </md-menu>
    </md-badge>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    notifications: [],
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
    ...mapActions({
      signOutAction: "auth/signOut",
      setNotification: "shared/setNotification",
    }),
    notificationDetails(notification) {
      this.markAsRead(notification.id);
      this.setNotification(notification.id).then((res) => {});
      switch (this.user.role[0].name) {
        case "customer":
          this.$router.push("/shipper/orders/details/" + notification.data.job.order_id);
          this.$emit("hideSideMenu");
          break;
        case "mover":
          this.$router.push("/carrier/history/details/" + notification.data.job.id);
          this.$emit("hideSideMenu");
          break;
        case "admin":
          this.$router.push("/admin/order-details/" + notification.data.job.order_id);
          this.$emit("hideSideMenu");
          break;
        default:
          this.$router.push("/");
      }
    },
    markAsRead(id) {
      axios
        .get("auth/read-notification/" + id)
        .then((res) => {
          this.getNotifications();
        })
        .catch((err) => {
          console.log(err);
        });
    },

    getNotifications() {
      if (this.authenticated) {
        this.notifications = this.user.notifications;
        Echo.private("App.User." + this.user.id).notification((res) => {
          this.notifications.push(res.notification);
          console.log("notifications: in admin: ", this.notifications);
        });
      }
    },
  },
};
</script>
<style scoped>
.md-icon {
  color: #fff !important;
}
</style>
