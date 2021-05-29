<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card class="main-card">
        <md-card-header>
          <span class="md-title">Edit Bank Information</span>
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
            >Update</md-button
          >
        </md-card-actions>
      </md-card>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axios from "axios";
import Snackbar from "../../../shared/Snackbar";
import Spinner from "../../../shared/Spinner";
export default {
  name: "EditGeneralInfo",
  components: {
    Snackbar,
    Spinner,
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

    isSubmitting: false,
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
  }),

  methods: {
    update() {
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
          this.snackbar.message = error.response.data.errors;
          this.snackbar.statusCode = error.response.status;
          this.snackbar.show = true;
        });
    },
    init() {
      axios.get("carrier/payments/" + this.$route.params.id).then((res) => {
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
.md-card {
  text-align: left;
  .md-card-content {
    padding: 20px;
  }
  .md-card-actions {
    display: flex;
    justify-content: flex-start;
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
</style>
