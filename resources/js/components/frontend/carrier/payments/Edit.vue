<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <b-card header="Edit Bank Informations" class="border-0 shadow text-left">
        <b-button @click="$router.back()" variant="light" class="add-btn">
          <b-icon icon="x"></b-icon>
        </b-button>
        <div>
          <b-form-group>
            <b-form-select
              v-model="form.currency"
              :options="currencies"
              ref="focusable"
            ></b-form-select>
          </b-form-group>
          <b-form-group>
            <b-form-input
              type="text"
              v-model="form.transit_number"
              required
              placeholder="Transit number"
            ></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-input
              type="number"
              v-model="form.institution_number"
              required
              :min="0"
              placeholder="Institution number"
            ></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-input
              type="number"
              v-model="form.account_number"
              required
              :min="0"
              placeholder="Account number"
            ></b-form-input>
          </b-form-group>
          <b-form-group>
            <b-form-input
              type="number"
              v-model="form.confirm_account_number"
              required
              :min="0"
              placeholder="Confirm account number"
            ></b-form-input>
          </b-form-group>
        </div>
        <div class="text-right">
          <b-spinner variant="primary" v-if="isSubmitting" />
          <b-button v-if="!isSubmitting" type="submit" class="" variant="primary"
            >Save</b-button
          >
        </div>
      </b-card>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import axios from "axios";
import Toaster from "../../../shared/Toaster";
export default {
  name: "Edit",
  components: {
    Toaster,
  },
  data: () => ({
    initialData: null,
    form: {
      currency: null,
      transit_number: null,
      institution_number: null,
      account_number: null,
      confirm_account_number: null,
    },
    currencies: [
      { value: null, text: "Select Currency" },
      { value: "CAD", text: "CAD - Canadian Dollar" },
      { value: "USD", text: "USD - US Dollar" },
    ],
    isSubmitting: false,
  }),

  methods: {
    submit() {
      this.isSubmitting = true;
      axios
        .put("carrier/payments/" + this.$route.params.id, this.form)
        .then((res) => {
          this.isSubmitting = false;
          this.$router.push("/carrier/payments");
        })
        .catch((error) => {
          console.log("eerrr: ", error);
          this.isSubmitting = false;
          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            error.response.data.errors
          );
        });
    },
    init() {
      axios.get("carrier/payments/" + this.$route.params.id).then((res) => {
        console.log("pay", res.data);
        this.form.currency = res.data.currency;
        this.form.transit_number = res.data.transit_number;
        this.form.institution_number = res.data.institution_number;
        this.form.account_number = res.data.account_number;
        this.form.confirm_account_number = res.data.account_number;
      });
    },
  },
  computed: {},
  created() {
    this.init();
  },
};
</script>

<style lang="scss" scoped>
.add-btn {
  position: absolute;
  top: 0;
  right: 0;
}
</style>
