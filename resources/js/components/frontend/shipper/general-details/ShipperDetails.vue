<template>
  <b-card class="border-0 shadow text-left" header="Details">
    <div>
      <div v-if="shipper">
        <div class="row">
          <span class="col-3">Firs name:</span>
          <span class="col-6">{{ shipper.first_name }}</span>
        </div>
        <div class="row">
          <span class="col-3">Last name:</span>
          <span class="col-6">{{ shipper.last_name }}</span>
        </div>
        <div class="row">
          <span class="col-3">Email:</span>
          <span class="col-6">{{ shipper.user.email }}</span>
        </div>
        <div class="row">
          <span class="col-3">Phone:</span>
          <span class="col-6">{{ shipper.user.phone }}</span>
        </div>
        <div class="row">
          <span class="col-3">Address:</span>
          <span class="col-6">{{ shipper.address.formatted_address }}</span>
        </div>
      </div>
      <div v-else class="text-center">
        <b-button to="add" variant="primary"> Add </b-button>
      </div>
    </div>
    <div class="mt-3 text-right">
      <b-button v-if="shipper" @click="edit()" variant="primary"> Edit </b-button>
    </div>
  </b-card>
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
    edit() {
      this.$router.push("edit/" + this.shipper.id);
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
.container {
  height: calc(100vh);
}
</style>
