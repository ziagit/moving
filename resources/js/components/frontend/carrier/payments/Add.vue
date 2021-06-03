<template>
  <div>
    <form @submit.prevent="submit" enctype="multipart/form-data">
      <md-card>
        <md-card-header>
          <span class="md-title">Add Banck Information</span>
          <md-button @click="$router.back()" class="md-icon-button add-btn">
            <md-icon>close</md-icon>
            <md-tooltip>Cancel</md-tooltip>
          </md-button>
        </md-card-header>
        <md-divider></md-divider>
        <md-card-content>
          <md-field>
            <md-select
              v-model="form.currency"
              :value="form.currency"
              name="country"
              id="country"
              placeholder="Country"
            >
              <md-option value="CAD">CAD - Canadian Dollar</md-option>
              <md-option value="USD">USD - US Dollar</md-option>
            </md-select>
          </md-field>
          <md-field>
            <label for="">Transit number</label>
            <md-input type="text" v-model="form.transit_number" required></md-input>
          </md-field>
          <md-field>
            <label for="">Institution number</label>
            <md-input
              type="number"
              v-model="form.institution_number"
              required
              :min="0"
            ></md-input>
          </md-field>
          <md-field>
            <label for="">Account number</label>
            <md-input
              type="number"
              v-model="form.account_number"
              required
              :min="0"
            ></md-input>
          </md-field>
          <md-field>
            <label for="">Confirm account number</label>
            <md-input
              type="number"
              v-model="form.confirm_account_number"
              required
              :min="0"
            ></md-input>
          </md-field>
        </md-card-content>
        <md-card-actions>
          <Spinner v-if="isSubmitting" />
          <md-button v-if="!isSubmitting" type="submit" class="md-primary md-small-fab"
            >Save</md-button
          >
        </md-card-actions>
      </md-card>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import GoogleAddress3 from "../../../shared/GoogleAddress3";
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
export default {
  name: "AddGeneralInfo",
  components: {
    Snackbar,
    Spinner,
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

    isSubmitting: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),
  mounted() {
    this.$refs.focusable.$el.focus();
  },
  methods: {
    submit() {
      this.isSubmitting = true;
      axios
        .post("carrier/payments", this.form)
        .then((res) => {
          this.isSubmitting = false;
          console.log("response ", res.data);
          this.$router.push("/carrier/payments");
        })
        .catch((error) => {
          this.isSubmitting = false;
          console.log("eerrr: ", error.response);
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .md-card-content {
    padding: 20px;
  }
  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
