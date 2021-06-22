<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <b-card header="Add Bank Informations" class="border-0 shadow text-left">
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
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Toaster from "../../../shared/Toaster";
export default {
  name: "AddGeneralInfo",
  components: {
    Toaster,
    GoogleAddress3,
  },
  data: () => ({
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
  mounted() {
    this.$refs.focusable.focus();
  },
  methods: {
    submit() {
      this.isSubmitting = true;
      axios
        .post("carrier/bank-info", this.form)
        .then((res) => {
          this.isSubmitting = false;
          console.log("response ", res.data);
          this.$router.push("/carrier/payments");
        })
        .catch((error) => {
          this.isSubmitting = false;
          console.log("eerrr: ", error.response);

          this.$refs.toaster.show(
            "danger",
            "b-toaster-top-center",
            "Error",
            error.response.data.errors
          );
        });
    },
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
