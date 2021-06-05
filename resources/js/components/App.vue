<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "App",
  mounted() {},
  beforeDestroy() {},
  methods: {},
};
</script>

<style lang="scss">
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
.input-tel__input {
  border: none !important;
  border-bottom: 1px solid #000 !important;
}
.input-tel__input:focus {
  outline: none !important;
  border: none !important;
}
#MazPhoneNumberInput-46_phone_number {
}
.shipper-payment-method {
  .md-dialog-container {
    min-height: 614px !important;
    min-width: 485px !important;
    padding: 20px !important;
  }
  .md-checkbox {
    margin: 0 !important;
    .md-checkbox-4p0bbz4d8 {
      font-size: 11px !important;
    }
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
    margin-left: -116px;
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
  .row {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    .col {
      flex: 50%;
      .md-card {
        min-height: 82px;
        background: #fff;
        margin: 8px;
        line-height: 37px;
        display: flex;
        cursor: pointer;
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
          .md-display-1 {
            font-size: 17px;
            line-height: 19.3px;
          }
          .md-body-1 {
            color: #8e8b8b;
            line-height: 16px;
            font-size: 11px;
          }
        }
      }
      .md-card:hover {
        box-shadow: none;
      }
    }
  }
  .actions {
    display: flex;
    justify-content: center;
  }
}
.md-dialog-container {
  min-width: 408px !important;
}
.md-menu-content-bottom-start .md-menu-content-small .md-menu-content .md-theme-default {
  top: 415px !important;
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
.md-stepper-label {
  color: #000 !important;
  font-weight: 600;
}
.md-steppers {
  background: none !important;
}
.break {
  min-height: 10px;
}
.tab {
  width: 30px;
}
.md-app-container {
  transform: none !important;
}

.app {
  height: 100% !important;
}

.padding-20 {
  padding: 20px !important;
}
.help {
  .md-tabs.md-theme-default .md-tabs-navigation {
    margin-left: 74px;
  }
}

/* .md-tabs-navigation {
  padding-left: 60px !important;
} */
/* .md-tabs.md-theme-default .md-tabs-navigation .md-button.md-active {
  color: #ffa500;
  color: var(--md-theme-default-primary-on-background, #ffa500);
}
.md-tabs.md-theme-default .md-tabs-navigation .md-button.md-active .md-icon {
  color: #ffa500;
  color: var(--md-theme-default-primary-on-background, #ffa500);
}
.md-tabs.md-theme-default .md-tabs-navigation .md-button.md-active {
  background: #ffa50014 !important;
} */

.home-content {
  .md-tabs.md-alignment-left .md-tabs-navigation {
    justify-content: center;
  }
}
.md-card {
  border-radius: 5px !important;
  /* box-shadow: 0 4px 16px rgba(0,0,0,.12); */
  //box-shadow: 0 1px 2px #11111142;
  //box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);
  box-shadow: rgba(0, 0, 0, 0.12) 0px 4px 16px;
  border: none;
  background: #fff !important;
}
.md-tabs.md-theme-default .md-tabs-navigation .md-button.md-active {
  background: #448aff24 !important;
}

.md-app .md-app-side-drawer .md-layout-row .md-reveal .md-theme-default {
  border: none !important;
}

.md-checkbox .md-checkbox-container {
  border-radius: 5px;
}

.md-checkbox.md-theme-default.md-checked .md-checkbox-container {
  background-color: #ffa500;
  border-color: #ffa500;
}

.md-radio.md-theme-default.md-checked .md-radio-container {
  background-color: #ffa500;
  border-color: #ffa500;
}

.md-radio.md-theme-default.md-checked .md-radio-container:after {
  background-color: #ef9c03;
}

.md-dialog-container,
.md-dialog-fullscreen {
  border-radius: 12px;
}

.no-shadow {
  box-shadow: none;
}

.md-menu-content {
  border-radius: 8px !important;

  .md-menu-content-container {
    border-radius: 8px !important;
  }
}

.info,
.question:hover {
  cursor: pointer;
}

.md-table-content {
  border-radius: 8px;
}

.pagination {
  display: flex;

  li {
    list-style-type: none !important;
    margin: 5px 10px;
  }
}

.line {
  color: #ddd;
}

.md-table-content {
  max-width: calc(100vw - 80px);
  overflow-x: auto !important;
}

.md-display-1 {
  font-weight: 500;
  font-size: 30px;
  line-height: 38px;
  color: #000 !important;
}

.md-body-1 {
  width: 100% !important;
}

.active {
  color: #ffa500 !important;
}

.md-accent {
  color: #ff5252 !important;
}

.md-list-item {
  .md-list-item-button {
    font-size: 14px !important;

    .md-list-item-content {
      min-height: 35px !important;
    }
  }
}

.hidden-input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}

.company-detail {
  .md-table-cell-container {
    width: 150px !important;
    white-space: nowrap !important;
    overflow: hidden;
    text-overflow: ellipsis;
  }
}

.md-primary {
  color: #ffa500 !important;
}

.md-seconday {
  color: #448aff !important;
}

.md-button.md-theme-default.md-raised:not([disabled]).md-primary {
  background-color: #ffa500;
}

.md-switch.md-theme-default.md-checked.md-primary .md-switch-thumb {
  background-color: #ffa500 !important;
}

.md-switch.md-theme-default.md-checked.md-primary .md-switch-container {
  background-color: #ffa6005b !important;
}
.md-list.md-theme-default .md-selected .md-list-item-content,
.md-list.md-theme-default .router-link-active .md-list-item-content {
  color: #ffa500 !important;
}
.md-checkbox-container {
  background-color: #fff !important;
  border-color: #ffa500 !important;
  color: #ffa500 !important;
}
.md-checkbox.md-theme-default.md-checked .md-checkbox-container:after {
  border-color: #ffa500 !important;
}
.md-raised {
  border-radius: 30px;
  padding: 0 10px;
  margin: 0;
  background: #ffa500 !important;
  color: #fff !important;
}
.md-button {
  text-transform: none !important; /*For Lower case use lowercase*/
}
.custom-button {
  border-radius: 30px;
  padding: 0 16px !important;
  margin: 0;
  background: #f97d4a;
  color: #fff !important;
  font-weight: 500 !important;
  font-size: 16px !important;
  min-height: 45px !important;
  height: 45px !important;
  min-width: 120px;
  box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
    0 1px 5px 0 rgb(0 0 0 / 12%);
  .md-ripple {
    padding: 0 30px;
  }
}
.rounded-primary-button {
  background: #ffa5001a !important;
  color: #f97d4a !important;
  .md-icon {
    color: #ffa500 !important;
  }
}
.rounded-secondary-button {
  background: #f97d4a !important;
  .md-icon {
    color: #fff !important;
  }
}
.custom-button-outline {
  border-radius: 30px;
  padding: 0 16px !important;
  margin: 0;
  color: #f97d4a !important;
  background: #ffa5001a !important;
  font-weight: 500 !important;
  font-size: 12px !important;
  min-height: 45px !important;
  height: 45px !important;
  min-width: 120px;
  box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%),
    0 1px 5px 0 rgb(0 0 0 / 12%);
}
.custom-button-outline:hover {
  color: #fff !important;
  background: #f97d4a !important;
}

.md-progress-bar-fill {
  background: #ffa500 !important;
}
.activeStep .md-stepper-label {
  font-size: 20px !important;
}

.vdp-datepicker__calendar .cell.selected {
  background: #ffa500 !important;
}

.vdp-datepicker__calendar {
  width: 100% !important;
}
@media only screen and (min-width: 600px) {
  .md-display-1 {
    font-size: 30px;
  }

  label {
    font-size: 14px;
  }
}
.m-bottom-2 .align-center .justify-center {
  display: none !important;
}
@media only screen and (max-width: 600px) {
  .section3 {
    .steps {
      .md-list {
        .md-list-item-content {
          padding: 0 !important;

          .md-headline {
            font-size: 14px !important;
          }

          .details {
            font-size: 10px !important;
          }
        }
      }
    }
  }
  .help {
    .md-tabs {
      .md-tabs-content {
        .md-tabs-container {
          .md-tab {
            .container {
              .content {
                padding: 20px 0 !important;
              }
            }
          }
        }
      }
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
        .md-card {
          min-height: 82px;
          background: #fff;
          margin: 8px;
          line-height: 37px;
          display: flex;
          cursor: pointer;
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
            .md-display-1 {
              font-size: 17px;
              line-height: 19.3px;
            }
            .md-body-1 {
              line-height: 16px;
              font-size: 11px;
            }
          }
        }
        .md-card:hover {
          box-shadow: none;
        }
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
