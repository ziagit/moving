<template>
  <div class="root">
    <vuescroll>
      <router-view></router-view>
    </vuescroll>
  </div>
</template>

<script>
import vuescroll from "vuescroll";
import Admin from "./backend/Admin";
import Home from "./frontend/Home";
export default {
  name: "App",
  components: {
    Home,
    Admin,
    vuescroll,
  },
  mounted() {},
  beforeDestroy() {},
  methods: {},
};
</script>

<style lang="scss">
.__bar-is-vertical {
  background: #ffa500 !important;
}
.root {
  height: 100vh !important;
}
h1,
h2,
h3,
h4,
h5,
h6,
p {
  font-family: "Roboto";
}
.completion {
  .card {
    .card-body {
      padding: 0 !important;
    }
  }
}
.progress {
  min-height: 140px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: none;
  p {
    margin: 0 !important;
  }
}
.order {
  .right {
    .card {
      .card-body {
        padding: 0 !important;
      }
    }
  }
}
.login,
.password,
.register {
  .card {
    .card-body {
      padding: 48px;
    }
  }
}
.b-sidebar {
  width: 250px !important;
  .b-sidebar-header {
    display: none !important;
  }
  .b-sidebar-body {
    background: #fff;
  }
}

.inbox {
  .card {
    .card-body {
      .jumbotron {
        background: none;
        border-radius: 0;
      }
    }
  }
}
.select-carrier {
  .price-container {
    .card-body {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }
  }
}
@media print {
  .no-print {
    visibility: hidden;
  }
}
.add-btn {
  position: absolute;
  top: 1;
  right: 1;
}
.react-code-input {
  input {
    font-family: "Roboto" !important;
  }
}

.shipper-payment-method {
  .md-dialog-container {
    min-height: 614px !important;
    min-width: 485px !important;
    padding: 20px !important;
  }
}
.google-address2 {
  .md-dialog-container,
  .md-dialog-fullscreen,
  .md-theme-default {
    max-width: 300px !important;
  }
}
.custom-cal {
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  padding: 10px;

  input {
    text-align: center;
    widows: 90% !important;
    height: 90% !important;
    border: none;
    margin-left: -141px;
    margin-top: 7px;
    background: #fff6e5;
  }
  input:focus {
    outline: none;
  }
}
a {
  cursor: pointer;
}
.origin {
  text-align: center;
  width: 100%;
  .row {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    .mini-card {
      min-height: 82px;
      background: #fff;
      margin: 8px;
      width: 100%;
      line-height: 37px;
      cursor: pointer;
      .card-body {
        padding: 0 !important;
        display: flex;
        .icon {
          align-items: center;
          display: flex;
          padding: 16px;
          background: #ffa5001a;
          border-top-left-radius: 5px;
          border-bottom-left-radius: 5px;
          img {
            max-width: none;
          }
        }
        .text {
          padding: 10px;
          text-align: left;
          display: flex;
          flex-direction: column;
          justify-content: center;
        }
      }
      .mini-card:hover {
        box-shadow: #ffa500;
      }
    }
  }
  .actions {
    display: flex;
    justify-content: center;
    .btn {
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      width: 58px;
      height: 58px;
      text-align: center;
      box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
        0 1px 5px 0 rgb(0 0 0 / 12%);
    }
  }
}

.vdp-datepicker__calendar {
  border-radius: 5px !important;
}
.google-address {
  .md-button {
    width: 162px !important;
    .md-button-content {
      font-size: 16px !important;
    }
  }
}
.pac-icon {
  display: none !important;
}
.pac-item {
  padding: 8px 8px 8px 12px !important;
  font-size: 14px !important;
  cursor: pointer;
}
.pac-item:hover {
  background: #ececec;
}
.pac-item-query {
  font-size: 14px !important;
}

.section0 {
  box-shadow: 0 2px 13px -7px grey;
}

.break {
  min-height: 10px;
}
.tab {
  width: 30px;
}

.padding-20 {
  padding: 20px !important;
}
.help {
  .md-tabs.md-theme-default .md-tabs-navigation {
    margin-left: 74px;
  }
}

.no-shadow {
  box-shadow: none;
}

.info,
.question:hover {
  cursor: pointer;
}

.pagination {
  display: flex;

  li {
    list-style-type: none !important;
    margin: 5px 10px;
  }
}

.line {
  height: 1px;
  width: 100%;
  background: #ddd;
}

.active {
  color: #ffa500 !important;
}

.hidden-input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}

.vdp-datepicker__calendar .cell.selected {
  background: #ffa500 !important;
}

.vdp-datepicker__calendar {
  width: 100% !important;
}
@media only screen and (min-width: 600px) {
}
.m-bottom-2 .align-center .justify-center {
  display: none !important;
}
@media only screen and (max-width: 600px) {
  .section3 {
    .steps {
    }
  }

  .origin {
    text-align: center;
    .row {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      .col {
        flex: 100%;
      }
    }
    .actions {
      display: flex;
      justify-content: center;
    }
  }
}
.pickup-date {
  text-align: center;
  .time-range {
    justify-content: center !important;
  }
}
</style>
