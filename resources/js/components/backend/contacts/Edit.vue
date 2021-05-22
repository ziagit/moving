<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-field>
        <label>Name</label>
        <md-input v-model="form.name"></md-input>
      </md-field>
      <md-field>
        <label>Phone</label>
        <md-input v-model="form.phone"></md-input>
      </md-field>
      <md-field>
        <label>Email</label>
        <md-input v-model="form.email"></md-input>
      </md-field>

      <md-button type="submit" class="md-primary md-small-fab">Done</md-button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
export default {
  name: "Edit",
  props: ["contact"],
  data: () => ({
    form: {
      name: null,
      phone: null,
      email: null,
    },
  }),
  watch: {},
  methods: {
    update() {
      axios
        .put("admin/contacts/" + this.contact.id, this.form)
        .then((res) => {
          console.log("response ", res.data);
          this.$emit("close-dialog");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
        });
    },
    init() {
      console.log(this.address);
      this.form.name = this.contact.name;
      this.form.phone = this.contact.phone;
      this.form.email = this.contact.email;
    },
  },
  created() {
    this.init();
  },
};
</script>

<style lang="scss" scoped>
.md-button {
  float: right !important;
}
</style>
