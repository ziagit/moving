<template>
  <div>
    <md-card>
      <md-card-header>
        <span class="md-title">Rate</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="rate" v-if="carrier">
          <div class="img">
            <img :src="'/images/uploads/mover-rate.svg'" width="400" alt="" />
          </div>
          <div class="text">
            <input v-if="editTogal" type="number" v-model="form.rate" ref="edit" />
            <h1 v-else>${{ carrier.hourly_rate }}/hr</h1>
            <div class="title">This is your price/hr for 2 movers a vehicle</div>
            <md-button v-if="editTogal" @click="update()" class="md-primary update"
              >Update</md-button
            >
          </div>
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button v-if="!editTogal" class="md-primary" @click="edit()">Edit</md-button>
      </md-card-actions>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    carrier: null,
    form: {
      rate: null,
    },
    active: false,
    editTogal: false,
  }),

  methods: {
    get() {
      axios
        .get("carrier/rate")
        .then((res) => {
          console.log("rates: ", res.data);
          this.carrier = res.data.carrier;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    edit() {
      this.editTogal = true;
      this.form.rate = this.carrier.hourly_rate;
    },
    update() {
      axios
        .put("carrier/rate/" + this.carrier.id, this.form)
        .then((res) => {
          this.get();
          this.editTogal = false;
        })
        .catch((error) => {
          console.log("Error: ", error);
        });
    },
    cancel() {
      this.value = "Disagreed";
    },
  },
  created() {
    this.get();
  },
};
</script>
>

<style lang="scss" scoped>
.md-card {
  text-align: left;
  .rate {
    display: flex;
    justify-content: space-between;
    .img {
      padding: 30px;
      display: flex;
      justify-content: center;
      width: 65%;
    }
    .text {
      width: 35%;
      text-align: left;
      padding: 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      h1 {
        color: #ffa500;
        font-size: 55px;
      }
      input {
        max-width: 200px;
        height: 95px;
        font-size: 55px;
        color: #ffa500;
        font-weight: 600;
      }
      input:focus {
        outline: none;
      }
      .update {
        position: absolute;
        bottom: 0;
      }
    }
    .md-button {
      position: absolute;
      right: 0;
    }
  }
}
@media only screen and (max-width: 600px) {
  .rate {
    flex-direction: column;
    .img {
      width: 100% !important;
    }
    .text {
      width: 100% !important;
    }
  }
}
</style>
