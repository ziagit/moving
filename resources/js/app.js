/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.Vue = require("vue");
import router from "./routes.js";

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

/* import VueMaterial from "vue-material";
import "vue-material/dist/vue-material.min.css";
import "vue-material/dist/theme/default.css"; */

/* import 'vue-material-design-icons/styles.css'; */

require("./bootstrap");
require("./store/subscriber");

/* const HelloJs = require('hellojs/dist/hello.all.min.js');
const VueHello = require('vue-hellojs');

HelloJs.init({
  google: '1044730439558-frnjivpacf33ejrqaa9suqlr909tjbeg.apps.googleusercontent.com',
  facebook: '952682128637553',
  twitter: '8EatGLGykHZX0W1wyRcTWHfAQ'
}, {
  redirect_uri: 'http://localhost:3000/api/moving/auth/google/callback'
});
Vue.use(VueHello, HelloJs); */
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component("pagination", require("laravel-vue-pagination"));

import store from "./store";
Vue.component("app", require("./components/App.vue").default);

//Vue.material.locale.dateFormat = "dd/MM/yyyy";

import axios from "axios";

//axios.defaults.baseURL = "http://localhost:8000/api/moving";
axios.defaults.baseURL = 'https://tingsapp.com/api/moving';
//axios.defaults.baseURL = 'http://34.121.144.224/api/moving';

//some time when I push to server api still points to localhost, this problem solved by runing 'npm run prod' and then push to server and change .env to production too in server,
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
store.dispatch("auth/attempt", localStorage.getItem("token")).then(() => {
    const app = new Vue({
        el: "#app",
        router,
        store,
      
        mounted() {
            /*   window.onbeforeunload = function (e) {
                e = e || window.event;
            
                // For IE and Firefox prior to version 4
                if (e) {
                    e.returnValue = 'Any string';
                }
            
                // For Safari
                return 'Any string';
            }; */
        }
    });
});
