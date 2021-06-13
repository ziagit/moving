<template>
  <div>
    <md-card>
      <md-card-header>
        <span class="md-title">Inbox</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="menu">
          <md-list class="md-triple-line md-dense">
            <div v-for="(not, index) in notifications" :key="index">
              <md-list-item
                @click="open(not)"
                :class="{ selected: selectedNot == not.id }"
              >
                <md-avatar>
                  <img src="https://placeimg.com/40/40/people/1" alt="People" />
                </md-avatar>
                <div class="md-list-item-text">
                  <span>{{ not.id }}</span>
                  <span>{{ not.notifiable_type }}</span>
                  <p>
                    {{ not.created_at }}
                  </p>
                </div>
              </md-list-item>
              <md-divider class="md-inset"></md-divider>
            </div>
          </md-list>
        </div>
        <div class="content">
          <div v-if="details">
            <div v-if="details.type == 'App\\Notifications\\JobCreated'">
              <p>This Order is created at: {{ details.created_at }}</p>
              <md-button class="md-primary">View in order page</md-button>
            </div>
            <div v-else-if="details.type == 'App\\Notifications\\JobUpdated'">
              <p>An Order is updated at: {{ details.created_at }}</p>
              <md-button class="md-primary">View in order page</md-button>
            </div>
            <div v-else-if="details.type == 'App\\Notifications\\CarrierPaid'">
              <p>A mover paid at: {{ details.created_at }}</p>
              <md-button class="md-primary">View in payment page</md-button>
            </div>
          </div>
        </div>
      </md-card-content>
    </md-card>
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
<style lang="scss" scoped>
.md-card {
  height: calc(100vh - 100px);
  .md-card-content {
    height: calc(100vh - 180px);
    display: flex;
    justify-content: space-between;
    .menu {
      flex: 1;
      max-width: 300px;
      border-right: solid 1px #ddd;
      padding-right: 10px;
      .md-list-item:hover {
        cursor: pointer;
      }
    }
    .content {
      padding: 20px;
      flex: 9;
    }
  }
}
.selected {
  background: #ffa60017;
}
</style>
