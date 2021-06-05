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
            <div v-for="i in [0, 1, 2, 3, 4, 5, 6, 7]" :key="i">
              <md-list-item @click="open(i)" :class="{ selected: s == i }">
                <md-avatar>
                  <img src="https://placeimg.com/40/40/people/1" alt="People" />
                </md-avatar>
                <div class="md-list-item-text">
                  <span>Ali Connors</span>
                  <span>Brunch this weekend?</span>
                  <p>
                    I'll be in your neighborhood doing errands this week. Do you want to
                    meet?
                  </p>
                </div>
              </md-list-item>
              <md-divider class="md-inset"></md-divider>
            </div>
          </md-list>
        </div>
        <div class="content"></div>
      </md-card-content>
    </md-card>
  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    s: 0,
    notifications: null,
  }),
  created() {
    console.log("notif", this.notifications);
  },
  methods: {
    ...mapActions({
      setNotification: "shared/setNotification",
    }),
    open(i) {
      this.s = i;
      console.log("open");
    },
  },
};
</script>
<style lang="scss" scoped>
.md-card {
  .md-card-content {
    display: flex;
    justify-content: space-between;
    .menu {
      flex: 1;
      max-width: 300px;
      border-right: solid 1px #ddd;
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
