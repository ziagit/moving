<template>
  <div>
    <form @submit.prevent="update" enctype="multipart/form-data">
      <md-card class="main-card">
        <md-button @click="$router.back()" class="md-icon-button add-btn">
          <md-icon>close</md-icon>
          <md-tooltip>Cancel</md-tooltip>
        </md-button>
        <h3>Edit Information</h3>
        <div class="carrier-details">
          <div class="row">
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
          </div>
        </div>
        <Spinner v-if="isSubmitting" />
        <md-button v-if="!isSubmitting" type="submit" class="md-primary md-small-fab"
          >Done</md-button
        >
      </md-card>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from "vuex";
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
          console.log("ressssssssssss", res.data);
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
.main-card {
  padding: 30px;
  text-align: center;
  box-shadow: none;
  border: solid 1px #ddd;

  .carrier-logo {
    text-align: center;
    margin-top: -40px;

    .md-large {
      background: #ddd;
    }

    .select-logo {
      position: absolute;
    }
  }

  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .md-field {
      flex: 25%;
    }
  }

  .add-btn {
    position: absolute;
    top: 0;
    right: 0;
  }
}
.company {
  .row {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;

    .md-field {
      flex: 32%;
    }
  }
}
</style>
