<template>
  <md-card>
    <md-card-header><span class="md-title">Account Details</span></md-card-header>
    <md-divider></md-divider>
    <md-card-content>
      <div v-if="shipper">
        <div>
          <div class="row">
            <span>Firs name:</span>
            <span>{{ shipper.first_name }}</span>
          </div>
          <div class="row">
            <span>Last name:</span>
            <span>{{ shipper.last_name }}</span>
          </div>
          <div class="row">
            <span>Email:</span>
            <span>{{ shipper.user.email }}</span>
          </div>
          <div class="row">
            <span>Phone:</span>
            <span>{{ shipper.user.phone }}</span>
          </div>
          <div class="row">
            <span>Address:</span>
            <span>{{ shipper.address.formatted_address }}</span>
          </div>
        </div>
      </div>
      <md-empty-state
        v-else
        class="md-primary"
        md-icon="sentiment_satisfied_alt"
        md-label="No details available"
        md-description="Click bellow link to add new details"
      >
        <md-button to="add" class="md-default md-raised md-icon-button">
          <md-icon>add</md-icon>
        </md-button>
      </md-empty-state>
    </md-card-content>
    <md-card-actions>
      <md-button v-if="shipper" :to="{ path: 'edit/' + shipper.id }" class="md-primary">
        Edit
        <md-tooltip>Edit profile</md-tooltip>
      </md-button>
    </md-card-actions>
  </md-card>
</template>

<script>
import axios from "axios";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "GeneralInfo",
  data: () => ({
    shipper: null,
  }),
  methods: {
    get() {
      axios
        .get("shipper/details")
        .then((res) => {
          console.log("shipper ", res.data);
          this.shipper = res.data;
        })
        .catch((error) => {
          console.log("Error: ", error);
        });
    },
  },
  computed: {
    ...mapGetters({
      authenticated: "auth/authenticated",
      user: "auth/user",
    }),
  },
  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  padding: 20px;
  text-align: left;
  .row {
    display: flex;
    > :first-child {
      min-width: 100px;
    }
  }

  .md-card-actions {
    display: flex;
    justify-content: flex-start;
  }
}
</style>
