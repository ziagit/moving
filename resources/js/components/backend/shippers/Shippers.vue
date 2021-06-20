<template>
  <div class="container" v-if="shippers">
    <EditShipper :shipper="shipper" v-on:close-it="editTogal = false" v-if="editTogal" />
    <b-card v-else class="shadow border-0 mt-5" header="Customers">
      <b-form-input placeholder="Search by name..." v-model="keywords" />
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Payment method</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(shipper, index) in shippers.data" :key="index">
            <td>{{ index + 1 }}</td>
            <td>{{ shipper.first_name }}</td>
            <td>{{ shipper.user ? shipper.user.email : "" }}</td>
            <td>{{ shipper.user ? shipper.user.phone : "" }}</td>
            <td>{{ shipper.address.formatted_address }}</td>
            <td>{{ shipper.stripe_customer_id ? "Added" : "Not added" }}</td>

            <td>
              <b-button
                variant="light"
                @click="edit(shipper)"
                v-b-tooltip.hover
                title="Edit"
              >
                <b-icon variant="primary" icon="pencil"></b-icon>
              </b-button>
              <b-button
                variant="light"
                v-b-tooltip.hover
                title="Delete"
                @click="changeAccount(shipper.user.id, 'Deleted')"
              >
                <b-icon variant="danger" icon="trash"></b-icon>
              </b-button>
              <b-button
                variant="light"
                v-b-tooltip.hover
                title="Lock"
                v-if="shipper.user.status == 'Active'"
                @click="changeAccount(shipper.user.id, 'Locked')"
              >
                <b-icon icon="lock" variant="success"></b-icon>
              </b-button>
              <b-button
                variant="light"
                v-else
                v-b-tooltip.hover
                title="Unlock"
                @click="changeAccount(shipper.user.id, 'Active')"
              >
                <b-icon variant="success" icon="unlock"></b-icon>
              </b-button>
            </td>
          </tr>
        </tbody>
      </table>
    </b-card>
    <pagination :limit="4" :data="shippers" @pagination-change-page="get"></pagination>
  </div>
</template>

<script>
import axios from "axios";
import EditShipper from "./EditShipper";
export default {
  name: "shipper",
  data: () => ({
    keywords: null,
    shippers: null,
    shipper: null,
    confirmTogal: false,
    editTogal: false,
    confirmation_text: null,
    status: null,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-shipper", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.shippers = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/shippers?page=" + page)
        .then((res) => {
          console.log("shpers: ", res.data.data);
          this.shippers = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    changeAccount(id, status) {
      this.$bvModal
        .msgBoxConfirm("Do you want this account to be " + status + "?")
        .then((value) => {
          if (value) {
            this.confirm(id, status);
          }
        })
        .catch((err) => {
          console.log("err", err);
        });
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },

    edit(data) {
      this.editTogal = true;
      this.shipper = data;
    },

    confirm(id, status) {
      console.log("id:", id, "status:", status);
      if (status == "Deleted") {
        axios
          .delete("admin/shippers" + id)
          .then((res) => {
            this.router.push("/admin/carriers");
          })
          .catch((err) => {
            console.log("Error: ", err);
          });
      } else {
        axios
          .put("admin/users/lock/" + id, { status: status })
          .then((res) => {
            console.log("ress", res.data);
            this.get();
          })
          .catch((err) => {
            console.log("Error: ", err);
          });
      }
    },
  },
  created() {
    this.get();
  },
  components: {
    EditShipper,
  },
};
</script>

<style lang="scss" scoped>
.container {
  min-height: calc(100vh - 50px);
  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
