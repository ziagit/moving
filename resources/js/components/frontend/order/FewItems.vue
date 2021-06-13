<template>
  <div class="few-items">
    <span class="md-display-1">Add your items</span>
    <div class="break"></div>
    <div class="break"></div>
    <div class="break"></div>
    <div v-if="items.length > 0">
      <md-card>
        <ul>
          <li v-for="(item, index) in items" :key="index">
            <div>
              <span>{{ item.name }}</span
              >:
              <span>{{ item.number }}</span>
            </div>
            <div>
              <md-button class="md-icon-button md-primary" @click="edit(item.code)"
                ><md-icon>edit</md-icon> <md-tooltip>Edit it</md-tooltip></md-button
              >
              <md-button class="md-icon-button remove" @click="remove(index)"
                ><md-icon>remove</md-icon> <md-tooltip>Remove it</md-tooltip></md-button
              >
            </div>
          </li>
        </ul>
      </md-card>
      <div class="break"></div>
      <div class="break"></div>
      <div class="break"></div>
    </div>
    <form>
      <md-button
        v-if="addTogal"
        @click="addTogal = false"
        class="md-raised md-icon-button rounded-secondary-button"
      >
        <md-icon>add</md-icon>
        <md-tooltip>add an item</md-tooltip>
      </md-button>

      <div class="item-row" v-else>
        <div class="search-box">
          <md-field class="name">
            <label>Item name</label>
            <md-input v-model="keywords" type="text" required></md-input>
          </md-field>
          <ul v-if="searchTogal">
            <li v-for="list in list" :key="list.id" @click="select(list)">
              {{ list.name }}
            </li>
          </ul>
          <ul v-if="notFoundTogal">
            <li>Not found</li>
          </ul>
        </div>
        <div class="number">
          <md-field>
            <label>How many</label>
            <md-input v-model="number" type="number" :min="1" required></md-input>
          </md-field>
          <input type="hidden" :value="code" />
        </div>
        <div class="add">
          <span v-if="!number" class="md-body-2 md-icon-button" @click="cancel()">
            <md-icon>remove</md-icon>
            <md-tooltip>Click to remove</md-tooltip>
          </span>
          <span v-else class="md-body-2 md-icon-button" @click="add(name, number, code)"
            >add
            <md-tooltip>Click to add</md-tooltip>
          </span>
        </div>
      </div>

      <div class="break"></div>
      <div class="break"></div>
      <div class="break"></div>
      <div class="actions">
        <md-button
          to="/order/moving-types"
          class="md-raised md-fab md-icon-button rounded-primary-button"
        >
          <md-icon>arrow_back</md-icon>
        </md-button>
        <div class="tab"></div>

        <md-button
          @click="next()"
          class="md-raised md-fab md-icon-button rounded-secondary-button"
        >
          <md-icon>arrow_forward</md-icon>
        </md-button>
      </div>
    </form>
    <Snackbar :data="snackbar" />
  </div>
</template>

<script>
import Snackbar from "../../shared/Snackbar";
import axios from "axios";
import localData from "../services/localData";
export default {
  name: "App",
  components: {
    Snackbar,
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
    snackbar: {
      show: false,
      message: null,
      statusCode: null,
    },
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
        this.snackbar.show = true;
        this.snackbar.message = "Search your items and add";
        this.snackbar.statusCode = "404";
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

    next() {
      if (this.items.length == 0) {
        this.snackbar.show = true;
        this.snackbar.message = "Add an item";
        this.snackbar.statusCode = "428";
      } else if (!this.addTogal) {
        this.snackbar.show = true;
        this.snackbar.message = "Click + sign to add your item in the list";
        this.snackbar.statusCode = "428";
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
.few-items {
  text-align: center;
  .md-card {
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
        .md-icon {
          color: red;
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
    width: 75%;

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

.md-menu-content-bottom-start .md-menu-content-small .md-menu-content .md-theme-default {
  top: 327px !important;
}
.actions {
  display: flex;
  justify-content: center;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type="number"] {
  -moz-appearance: textfield;
}
</style>
