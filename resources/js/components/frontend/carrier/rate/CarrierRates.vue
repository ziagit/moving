<template>
  <div>
    <!--     <md-dialog-confirm
      :md-active.sync="active"
      md-title="Caution!"
      md-content="Make sure it's not an accident!"
      md-confirm-text="Agree"
      md-cancel-text="Disagree"
      @md-cancel="cancel"
      @md-confirm="confirm"
    /> -->

    <md-card>
      <md-card-header>
        <span class="md-title">Rate</span>
      </md-card-header>
      <md-divider></md-divider>
      <md-card-content>
        <div class="rate" v-if="rate">
          <div class="img">
            <img :src="'/images/uploads/mover-rate.svg'" width="400" alt="" />
          </div>
          <div class="text">
            <input v-if="editTogal" type="number" v-model="rate.price" ref="edit" />
            <h1 v-else>${{ rate.price }}/hr</h1>
            <div class="title">This is your price/hr for 2 movers a vehicle</div>
            <md-button v-if="editTogal" @click="update()" class="md-primary update"
              >Update</md-button
            >
          </div>
        </div>
      </md-card-content>
      <md-card-actions>
        <md-button v-if="!editTogal" class="md-primary" @click="edit()" :autofocus="true"
          >Edit</md-button
        >
      </md-card-actions>
    </md-card>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    rate: null,
    active: false,
    editTogal: false,
  }),

  methods: {
    get() {
      axios
        .get("carrier/rate")
        .then((res) => {
          console.log("rates: ", res.data);
          this.rate = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    edit() {
      this.editTogal = true;
      this.$refs.edit.focus();
    },
    update() {
      axios
        .put("carrier/rate/" + this.rate.id, this.rate)
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
