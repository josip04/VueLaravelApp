import routes from './routes.js';
import Vue from 'vue';
import axios from 'axios';
import VueAlertify from 'vue-alertify';
 
Vue.use(VueAlertify);


require('./bootstrap');

window.Vue = require('vue');
Vue.component('app-component', require('./components/App.vue').default);


const baseURL = 'http://localhost:8000/aplikacija/public/api/';
Vue.prototype.$axios =  axios.create({ baseURL });
const app = new Vue({
  router : routes
}).$mount('#app');
