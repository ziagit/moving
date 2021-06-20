<template>
  <div class="container">
    <b-modal id="modal-update" title="Update Data" :hide-footer="true">
      <Edit v-on:close-dialog="refresh" :item="item" />
    </b-modal>
    <!-- add dialog -->
    <b-modal id="modal-add" size="md" title="Add New Type" :hide-footer="true">
      <Add v-on:close-dialog="refresh" />
    </b-modal>
    <b-card header="Number of Movers" class="border-0 shadow text-left mt-5">
      <b-form-input placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titel</th>
            <th>Code</th>
            <th>Time to move</th>
            <th>Disposal fee</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in items.data" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.code }}</td>
            <td>{{ item.moving_cost }} min</td>
            <td>${{ item.disposal_fee }}</td>

            <td>
              <b-button variant="light" @click="edit(item)">
                <b-icon variant="primary" icon="pencil"></b-icon>
              </b-button>
              <b-button variant="light" @click="remove(item.id)">
                <b-icon variant="danger" icon="trash"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
      <b-button class="add-btn" variant="primary" v-b-modal.modal-add>
        <b-icon icon="plus"></b-icon>
      </b-button>
    </b-card>
    <pagination :limit="4" :data="items" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import Add from "./Add";
import Edit from "./Edit";
import axios from "axios";

export default {
  name: "item",
  data: () => ({
    keywords: null,
    items: null,
    item: null,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-item", { params: { keywords: this.keywords } })
        .then((res) => {
          console.log("search data: ", res.data.data);
          this.items = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/few-items?page=" + page)
        .then((res) => {
          this.items = res.data;
          console.log("items: ", res.data.data);
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
      this.item = data;
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
        .delete("admin/few-items/" + id)
        .then((res) => {
          console.log("deleted", res.data);
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
    Add,
    Edit,
  },
};
</script>
<style scoped lang="scss">
.container {
  height: calc(100vh - 5px);
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
