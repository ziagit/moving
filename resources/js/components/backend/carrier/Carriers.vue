<template>
  <div class="container" v-if="carriers">
    <b-card header="Movers" class="border-0 shadow text-left mt-5">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Company name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(carrier, index) in carriers.data" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ carrier.company }}</td>
            <td>{{ carrier.user.email }}</td>
            <td>{{ carrier.user.phone }}</td>
            <td>
              <b-button variant="light" @click="edit(carrier)">
                <b-icon icon="pencil"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
    </b-card>
    <pagination :limit="4" :data="carriers" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Edit from "./Edit";
export default {
  name: "carrier",
  data: () => ({
    keywords: null,
    carriers: null,
    carrier: null,
    deleteTogal: false,
    editTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-carrier", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.carriers = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/carriers?page=" + page)
        .then((res) => {
          this.carriers = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addTogal = true;
      this.stateData = this.states;
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.$router.push("carrier-details/" + data.id);
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/carriers/" + this.selectedId)
        .then((res) => {
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    cancel() {},
  },
  created() {
    this.get();
  },
  components: {
    Edit,
  },
};
</script>

<style lang="scss" scoped>
.container {
  height: calc(100vh - 50px);

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
