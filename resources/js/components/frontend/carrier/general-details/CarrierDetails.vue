<template>
  <md-card>
    <md-card-content v-if="carrier">
      <div v-if="carrier.company !== 'null'" class="carrier-logo">
        <md-avatar class="md-large">
          <md-icon v-if="carrier.logo === 'undefined'">sentiment_satisfied_alt</md-icon>
          <img v-else :src="'/images/uploads/' + carrier.logo" alt="Logo" />
        </md-avatar>
      </div>
      <div class="break"></div>
      <div class="break"></div>
      <div>
        <div>
          <h1>{{ carrier.company }}</h1>
          <span class="md-subheading">
            {{ carrier.first_name }}
            <span class="line">|</span>
            {{ carrier.last_name }}
            <span class="line">|</span>
            {{ carrier.address.formatted_address }}
          </span>
          <br />
          <span class="md-subheading">
            {{ carrier.address.country }}
            <span class="line">|</span>
            {{ carrier.address.state }}
            <span class="line">|</span>
            {{ carrier.address.city }}
            <span class="line">|</span>
            {{ carrier.address.zip }}
          </span>
          <br />
          <span class="md-subheading">
            {{ carrier.contact.phone }}
            <span v-if="carrier.company !== 'null'" class="line">|</span>
            <span v-if="carrier.company !== 'null'">{{ carrier.website }}</span>
          </span>
          <br />
        </div>
        <div v-if="carrier.company !== 'null'" class="md-body-1">
          <br />
          <span class="subheading">About company</span>
          <p v-show="carrier.detail">{{ carrier.detail }}</p>
        </div>
      </div>
    </md-card-content>
    <md-card-actions v-if="carrier">
      <md-button :to="{ path: 'edit/' + 1 }" class="md-primary md-icon-button">
        <md-icon>edit</md-icon>
        <md-tooltip>Edit profile</md-tooltip>
      </md-button>
    </md-card-actions>
    <md-empty-state
      v-else
      class="md-primary"
      md-icon="sentiment_satisfied_alt"
      md-label="Not available"
      md-description="Click + icon to add"
    >
      <md-button to="add" class="md-icon-button md-raised">
        <md-icon>add</md-icon>
        <md-tooltip>Add new data</md-tooltip>
      </md-button>
    </md-empty-state>
  </md-card>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
  name: "CarrierDetails",
  data: () => ({
    carrier: null,
    hasCompany: false,
    temp: {
      me: null,
      country: null,
    },
  }),
  methods: {
    ...mapActions({
      tempData: "shared/tempData",
    }),
    async get() {
      await axios
        .get("carrier/details")
        .then((res) => {
          console.log("carrier: ", res.data);
          this.carrier = res.data;
          this.temp.me = this.carrier.id;
          this.tempData(this.temp).then((res) => {});
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },

  created() {
    this.get();
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  box-shadow: none;
  text-align: center;

  .md-card-actions {
    display: flex;
    justify-content: space-around;
  }
}

.carrier-logo {
  text-align: center;
  .md-avatar {
    box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
    min-width: 84px;
    min-height: 84px;
    color: #ffa500;
  }
}

.md-body-1 {
  width: 50%;
  margin: auto;
}
</style>
