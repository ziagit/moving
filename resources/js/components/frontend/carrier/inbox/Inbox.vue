<template>
  <div>
    <b-card header="Notifications" class="border-0 shadow text-left">
      <div class="row">
        <div class="menu col-3">
          <b-list-group>
            <div v-for="(not, index) in notifications" :key="index">
              <b-list-group-item
                button
                class="border-0 item"
                @click="open(not)"
                :class="{ selected: selectedNot == not.id }"
              >
                <span>{{ index + 1 }} : {{ not.type.substring(18) }}</span>
              </b-list-group-item>
            </div>
          </b-list-group>
        </div>
        <div class="content col-9">
          <div v-if="details">
            <div v-if="details.type == 'App\\Notifications\\JobCreated'">
              <p>This Order is created at: {{ format(details.created_at) }}</p>
              <br />
              <b-button class="md-primary" @click="readMore(details.data.job.id)"
                >Read more</b-button
              >
            </div>
            <div v-else-if="details.type == 'App\\Notifications\\JobUpdated'">
              <p>An Order is updated at: {{ format(details.created_at) }}</p>
              <br />
              <b-button class="md-primary" @click="readMore(details.data.job.id)"
                >Read more</b-button
              >
            </div>
            <div v-else-if="details.type == 'App\\Notifications\\CarrierPaid'">
              <p>A mover paid at: {{ format(details.created_at) }}</p>
              <br />
              <b-button class="md-primary" @click="readPayment(details)"
                >Read more</b-button
              >
            </div>
          </div>
        </div>
      </div>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
import dateFormatter from "../../services/dateFormatter";
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    selectedNot: null,
    notifications: null,
    details: null,
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
    getNotifications() {
      this.notifications = this.user.notifications;
      Echo.private("App.User." + this.user.id).notification((res) => {
        this.notifications.push(res.notification);
        console.log("notifications ", this.notifications);
      });
    },
    format(date) {
      return dateFormatter.format(date);
    },
    open(not) {
      this.selectedNot = not.id;
      this.details = not;
    },
    readMore(id) {
      console.log("details", id);
      this.$router.push("/carrier/history/details/" + id);
    },
    readPayment(detail) {
      console.log("detais", detail);
    },
  },
};
</script>
<style lang="scss" scoped>
.selected {
  background: #ffa60017;
}
.not-id {
  width: 100px;
  word-break: keep-all;
  display: inline-block;
  overflow: hidden;
}
</style>
