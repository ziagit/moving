<template>
  <div class="container" v-if="cities">
    <!-- delete dialog-->
    <b-modal id="modal-update" title="Update Country Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :city="city" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add new country" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Cities" class="border-0 shadow text-left mt-5">
      <b-input type="search" placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th md-numeric>ID</th>
            <th>Name</th>
            <th>State</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="city in cities.data" :key="city.id">
            <td md-numeric>{{ city.id }}</td>
            <td md-sort-by="city.name">{{ city.name }}</td>
            <td>{{ city.state.name }}</td>
            <td md-label="Actions">
              <b-button variant="light" @click="edit(city)">
                <b-icon icon="pencil" variant="primary"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(city.id)">
                <b-icon icon="trash-fill" variant="danger"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button class="add-btn" variant="primary" v-b-modal.modal-add>
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
    <pagination :limit="4" :data="cities" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "City",
  components: {
    Add,
    Edit,
  },
  data: () => ({
    keywords: null,
    cities: null,
    city: null,
    addTogal: false,
    editTogal: false,
    deleteTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  created() {
    this.get();
  },

  methods: {
    search() {
      axios
        .get("admin/search-city", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("res ", res.data.data);
          this.cities = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/cities?page=" + page)
        .then((res) => {
          console.log("cities ", res.data.data);
          this.cities = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    refresh() {
      this.$bvModal.hide("modal-add");
      this.$bvModal.hide("modal-update");
      this.get();
    },
    edit(data) {
      this.city = data;
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
        .delete("admin/cities/" + id)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
  },
};
</script>
<style scoped lang="scss">
.container {
  height: calc(100vh - 50px);
  .add-btn {
    position: absolute;
    top: 0px;
    right: 0px;
  }
}
</style>
