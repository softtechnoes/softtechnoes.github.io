// load all dependencies
// import Vue from 'vue';
// window.Vue = Vue;
// import { createApp } from 'vue';
// const Vue = createApp();
// const Vue = Vue.createApp(App);
// app.config.globalProperties.$axios = axios;
// // Current url
// Vue.prototype.$CurrentUrl = window.location.pathname;

// const app1 = createApp();

// import { createApp } from 'vue';
// import HelloVue from './components/HelloVue.vue';

// const app = createApp();
// app.config.globalProperties.test = "Test value";
// app.config.globalProperties.$http = () => {}
// app1.config.globalProperties.$CurrentUrl = window.location.pathname;
// app1.config.globalProperties.test = "Test value";

// Axios, http requests
import axios from 'axios';
window.axios = axios;
// Mixins for distributed reusable functionalities : Lang and browser notifications
import helper from './composables/helper'
window.helper = helper;




//Form Validation package
// import Vuelidate from 'vuelidate';
// Vue.use(Vuelidate);

// Luxon package replace of moment package
// import { DateTime } from 'luxon';
// Vue.prototype.$DateTime = DateTime;
// import { Interval } from 'luxon';
// Vue.prototype.$Interval = Interval;

//Idle package for detecting when app goes to idle
// import { store } from "./store";
// import IdleVue from 'idle-vue';
// Vue.use(IdleVue, { store });
// Routers 
// import VueRouter from 'vue-router'
// Vue.use(VueRouter)
// Telephone validation
// import VueTelInput from 'vue-tel-input';
// import 'vue-tel-input/dist/vue-tel-input.css';
// Vue.use(VueTelInput) 
// Flash
// import Vue from 'vue';

// window.events = new Vue();
// window.events = require('vue');
// window.flash = function(message, type = 'success') {
//     window.events.$emit('flash', { message, type });
// };

// Google map
// process.env.MIX_APP_LOCALE
// import * as VueGoogleMaps from 'vue2-google-maps'
// Vue.use(VueGoogleMaps, {
//   load: {
//     key: process.env.MIX_APP_GMAP_KEYS,
//     // libraries: 'places', // This is required if you use the Autocomplete plugin
//     language: process.env.MIX_APP_LOCALE,
//     region: 'CA',
//   },
// })

// Loading lodash functions (never load all lodash, only required functions)
window._get = require('lodash/get');
window._eachRight = require('lodash/eachRight');
window._forEach = require('lodash/forEach');
window._replace = require('lodash/replace');

// Translations
// Vue.prototype.$Lang_get = window.helper.Lang_get;
// app1.config.globalProperties.$Lang_get = window.helper.Lang_get;
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    window.axios.defaults.headers.common['Accept'] = 'application/json';
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('auth_token');
    
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}