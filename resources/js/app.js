/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// require('./bootstrap');
require('./base_config');
// require('./echo_client'); // Setting up Echo client and io,
import store from './store';
// import router from './routes.js';
import router from './router';

import "@fortawesome/fontawesome-free/css/all.min.css";
import "/css/tailwind.css";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



import { createApp } from 'vue';

const app = createApp();


app.config.globalProperties.$Lang_get = window.helper.Lang_get;
// set axios gloally 
// app.config.globalProperties.$axios = axios;

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// window.events = app;
// window.flash = function(message, type = 'success') {
//     window.events.$emit('flash', { message, type });
// };
// import Vuelidate from 'vuelidate';
// Vue.use(Vuelidate);

app.use(router);
app.use(store);
app.use(VueSweetalert2);
app.mount('#app');