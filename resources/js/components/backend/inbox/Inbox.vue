<template>
  <div class="container inbox">
    <b-card header="Notifications" class="border-0 shadow mt-3 mb-3">
      <div class="row">
        <div class="menu col-3">
          <b-list-group>
            <div v-for="(not, index) in notifications" :key="index">
              <b-list-group-item
                class="border-0 item"
                @click="open(not)"
                :class="{ selected: selectedNot == not.id }"
              >
                <span>{{ not.id }}</span>
                <span>{{ not.notifiable_type }}</span>
              </b-list-group-item>
            </div>
          </b-list-group>
        </div>
        <b-jumbotron
          class="col-9 mb-0"
          header="Notification"
          lead="I'm pleased to notify you"
        >
          <div v-if="details">
            <div v-if="details.type == 'App\\Notifications\\JobCreated'">
              <p>This Order is created at: {{ details.created_at }}</p>
              <b-button variant="primary">View in order page</b-button>
            </div>
            <div v-else-if="details.type == 'App\\Notifications\\JobUpdated'">
              <p>An Order is updated at: {{ details.created_at }}</p>
              <b-button variant="primary">View in order page</b-button>
            </div>
            <div v-else-if="details.type == 'App\\Notifications\\CarrierPaid'">
              <p>A mover paid at: {{ details.created_at }}</p>
              <b-button variant="primary">View in payment page</b-button>
            </div>
          </div>
        </b-jumbotron>
      </div>
    </b-card>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: () => ({
    selectedNot: null,
    notifications: null,
    details: null,
  }),
  created() {
    this.get();
    console.log("notif", this.notifications);
  },
  methods: {
    get() {
      axios.get("admin/notifications").then((res) => {
        this.notifications = res.data;
        console.log("p:", JSON.parse(res.data[1].data));
        console.log("notifications:", res.data);
      });
    },
    open(not) {
      this.selectedNot = not.id;
      this.details = not;
    },
  },
};
</script>
<style lang="scss">
.container {
  height: calc(100vh - 162px);
  .item {
    cursor: pointer;
    font-size: 12px;
  }
  .item:hover {
    background: #e7e3db;
  }
  .selected {
    background: #ffa60017;
  }
}
</style>
