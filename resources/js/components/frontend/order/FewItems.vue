<template>
  <div class="origin">
    <h3>Add your items</h3>
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div v-if="items.length > 0">
      <b-card class="item-card px-0 shadow border-0">
        <ul>
          <li v-for="(item, index) in items" :key="index">
            <div>
              <span>{{ item.name }}</span
              >:
              <span>{{ item.number }}</span>
            </div>
            <div>
              <b-icon
                @click="edit(item.code)"
                icon="pencil"
                variant="primary"
                class="icon"
              ></b-icon>
              <b-icon
                @click="remove(index)"
                icon="trash"
                variant="danger"
                class="icon"
              ></b-icon>
            </div>
          </li>
        </ul>
      </b-card>
      <div class="break"></div>
      <div class="break"></div>
      <div class="break"></div>
    </div>
    <form>
      <b-button
        v-if="addTogal"
        @click="addTogal = false"
        variant="primary"
        v-b-tooltip.hover
        title="Add an item"
      >
        <b-icon icon="plus-circle"></b-icon>
      </b-button>

      <div class="item-row" v-else>
        <div class="search-box">
          <b-input-group>
            <b-form-input
              v-model="keywords"
              type="text"
              required
              placeholder="Search item name"
            ></b-form-input>
            <b-form-input
              v-model="number"
              required
              placeholder="How many"
              type="number"
              :min="1"
            ></b-form-input>
            <input type="hidden" :value="code" />
            <b-input-group-append>
              <b-button variant="primary" v-if="!number" @click="cancel()">-</b-button>
              <b-button variant="primary" v-else @click="add(name, number, code)"
                >+</b-button
              >
            </b-input-group-append>
          </b-input-group>
          <ul v-if="searchTogal">
            <li v-for="list in list" :key="list.id" @click="select(list)">
              {{ list.name }}
            </li>
          </ul>
          <ul v-if="notFoundTogal">
            <li>Not found</li>
          </ul>
        </div>
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="break"></div>

      <div class="actions">
        <b-button @click="back()" variant="light">
          <b-icon icon="arrow-left"></b-icon>
        </b-button>
        <div class="tab"></div>
        <b-button @click="next()" variant="primary">
          <b-icon icon="arrow-right"></b-icon>
        </b-button>
      </div>
    </form>
    <Toaster ref="toaster" />
  </div>
</template>

<script>
import Toaster from "../../shared/Toaster";
import axios from "axios";
import localData from "../services/localData";
export default {
  name: "App",
  components: {
    Toaster,
  },
  data: () => ({
    items: [],
    list: null,
    keywords: null,
    name: null,
    number: null,
    code: null,
    addTogal: true,
    inputTogal: false,
    searchTogal: false,
    notFoundTogal: false,
    exist: false,
  }),
  watch: {
    keywords(after, before) {
      this.get();
    },
    number(value) {
      if (value != null || value < 1) {
        return true;
      }
    },
  },
  created() {
    this.$emit("progress", 2);
    this.init();
    localData.save("cr", this.$router.currentRoute.path);
  },
  methods: {
    get() {
      axios
        .get("search-item", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          if (res.data.data.length < 0) {
            this.searchTogal = false;
            this.notFoundTogal = true;
          } else {
            this.list = res.data.data;
            this.notFoundTogal = false;
            this.searchTogal = true;
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    select(selected) {
      this.searchTogal = false;
      this.keywords = selected.name;
      this.name = selected.name;
      this.code = selected.code;
    },
    add(name, number, code) {
      if (name == null || number == null || number < 1 || code == null) {
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-center",
          "Warning",
          "Search your items and add"
        );
      } else {
        for (let i = 0; i < this.items.length; i++) {
          if (this.items[i].code === code) {
            this.items[i].name = name;
            this.items[i].code = code;
            this.items[i].number = number;
            this.exist = true;
          }
        }
        if (!this.exist) {
          this.exist = false;
          this.items.push({
            name: name,
            number: number,
            code: code,
          });
        }
        this.name = null;
        this.number = null;
        this.code = null;
        this.keywords = null;
        this.addTogal = true;
      }
    },
    cancel() {
      this.addTogal = true;
    },
    edit(code) {
      this.addTogal = false;
      let d = this.items.filter((res) => {
        return res.code === code;
      });
      this.name = d[0].name;
      this.keywords = d[0].name;
      this.number = d[0].number;
      this.code = d[0].code;
    },
    remove(index) {
      this.items.splice(index, 1);
    },
    back() {
      this.$router.push("/order/moving-types");
    },
    next() {
      if (this.items.length == 0) {
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-center",
          "Warning",
          "Add an item"
        );
      } else if (!this.addTogal) {
        this.$refs.toaster.show(
          "warning",
          "b-toaster-top-center",
          "Warning",
          "Click + sign to add your item in the list"
        );
      } else {
        localData.save("moving-items", this.items);
        this.$router.push("floors");
      }
    },
    init() {
      var items = localData.read("moving-items");
      if (items) {
        this.items = items;
      }
    },
  },
};
</script>

<style lang="scss">
.origin {
  .item-card {
    margin: 0;
    ul {
      margin: 0 0 0 10px;
      padding: 0;
      li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        list-style-type: none;
        margin: 0;
        padding: 0;
        .icon {
          cursor: pointer;
          margin: 5px;
        }
      }
    }
  }
}
.item-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  .search-box {
    position: relative;
    width: 100%;
    ul {
      border-bottom-right-radius: 5px;
      border-bottom-left-radius: 5px;
      background: #fff;
      position: absolute;
      width: 100%;
      top: 53px;
      margin: 0;
      padding: 3px 0;
      text-align: left;
      z-index: 100;
      box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
        0 1px 5px 0 rgb(0 0 0 / 12%);
      li {
        list-style-type: none;
        padding: 2px 9px;
        cursor: pointer;
      }
      li:hover {
        background: #ddd;
      }
    }
  }
  .number {
    width: 100px;
    input {
      width: 100%;
    }
  }
  .add {
    background: #f97d4a;
    border-radius: 19px;
    .md-icon {
      color: #fff;
    }
  }
  .add:hover {
    cursor: pointer;
  }
}
.actions {
  display: flex;
  justify-content: center;
}
</style>
