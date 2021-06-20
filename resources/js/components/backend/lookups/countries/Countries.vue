<template>
  <div class="container" v-if="countries">
    <!-- edit dialog -->
    <b-modal id="modal-update" title="Update Country Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :country="countryData" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add new country" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Contries" class="shadow border-0 mt-5">
      <b-form-input type="search" placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <tr>
          <th md-numeric>ID</th>
          <th>Name</th>
          <th>Code</th>
          <th>Actions</th>
        </tr>
        <tr v-for="country in countries.data" :key="country.id">
          <td md-numeric>{{ country.id }}</td>
          <td>{{ country.name }}</td>
          <td>{{ country.code }}</td>

          <td>
            <b-button variant="light" @click="edit(country)">
              <b-icon icon="pencil" variant="primary"></b-icon>
            </b-button>
            <b-button variant="light" @click="remove(country.id)">
              <b-icon icon="trash-fill" variant="danger"></b-icon>
            </b-button>
          </td>
        </tr>
      </table>
      <b-button class="add-btn" variant="primary" v-b-modal.modal-add>
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
    <pagination :limit="4" :data="countries" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "Countries",
  data: () => ({
    keywords: null,
    countries: null,
    countryData: {},
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-country", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("search data: ", res.data.data);
          this.countries = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/countries?page=" + page)
        .then((res) => {
          console.log("countries: ", res.data);
          this.countries = res.data;
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
      this.countryData = data;
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
        .delete("admin/countries/" + id)
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
    top: 0px;
    right: 0px;
  }
}
</style>
