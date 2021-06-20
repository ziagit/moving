<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :vehicle="vehicle" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Vehicles" class="border-0 shadow text-left mt-5">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Code</th>
            <th>Recommended for</th>
            <th>Base fare</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="vehicle in vehicles" :key="vehicle.id">
            <td>{{ vehicle.id }}</td>
            <td>{{ vehicle.name }}</td>
            <td>{{ vehicle.code }}</td>
            <td>{{ vehicle.recommended }}</td>
            <td>${{ vehicle.base_fare }}</td>
            <td>
              <b-button variant="light" @click="edit(vehicle)">
                <b-icon variant="primary" icon="pencil"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(vehicle.id)">
                <b-icon icon="trash" variant="danger"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button variant="primary" class="add-btn" v-b-modal.modal-add>
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "vehicle",
  data: () => ({
    keywords: null,
    vehicles: null,
    vehicle: null,
  }),

  methods: {
    get() {
      axios
        .get("admin/vehicle")
        .then((res) => {
          this.vehicles = res.data;
          console.log("vehicles: ", res.data);
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    refresh() {
      this.$bvModal.hide("modal-update");
      this.$bvModal.hide("modal-add");
      this.get();
    },
    edit(data) {
      this.vehicle = data;
      this.$bvModal.show("modal-update");
    },
    remove(id) {
      this.$bvModal
        .msgBoxConfirm("Are you sure?")
        .then((value) => {
          if (value) {
            this.confirm(id);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    confirm(id) {
      axios
        .delete("admin/vehicle/" + id)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
  created() {
    this.get();
  },

  components: {
    Add,
    Edit,
  },
};
</script>
<style scoped lang="scss">
.container {
  height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
