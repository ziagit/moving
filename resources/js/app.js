/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 window.Vue = require('vue');

import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';

/* import 'vue-material-design-icons/styles.css'; */

require('./bootstrap');
require('./store/subscriber')

Vue.use(VueMaterial)
/* 
import Vue2TouchEvents from 'vue2-touch-events'
 
Vue.use(Vue2TouchEvents) */
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('pagination', require('laravel-vue-pagination'));

import store from "./store";
Vue.component('app', require('./components/App.vue').default);

Vue.material.locale.dateFormat = 'dd/MM/yyyy'

import router from './routes.js'
import Admin from './components/backend/Admin';
import Home from './components/frontend/Home';
import axios from 'axios';

//axios.defaults.baseURL = 'http://localhost:8000/api/moving';
//axios.defaults.baseURL = 'http://34.121.144.224/api/moving';
axios.defaults.baseURL = 'https://tingsapp.com/api/moving';
//some time when I push to server api still points to localhost, this problem solved by runing 'npm run prod' and then push to server and change .env to production too in server, 
/** 
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
store.dispatch('auth/attempt', localStorage.getItem('token')).then(() => {
    const app = new Vue({
        el: '#app',
        router,
        store,
        components: {
            Home,
            Admin
        },
        mounted() {
            console.log("mounted.")
          /*   window.onbeforeunload = function (e) {
                e = e || window.event;
            
                // For IE and Firefox prior to version 4
                if (e) {
                    e.returnValue = 'Any string';
                }
            
                // For Safari
                return 'Any string';
            }; */
        },
    });
})


