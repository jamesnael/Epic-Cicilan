/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import VueRouter from 'vue-router'
import Vuetify from 'vuetify';

require('./bootstrap');
require('./v-mixins');

window.Vue = require('vue');

Vue.use(VueRouter)
Vue.use(Vuetify);


Vue.component('base-layout', require('./components/BaseLayout.vue').default);
Vue.component('table-layout', () => import('./components/Table.vue'));
require('./../../Modules/SalesAgent/Resources/js/app');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const router = new VueRouter({
    mode: 'history',
})
const vuetify = new Vuetify({
  icons: {
    iconfont: 'mdi',
  },
})

const app = new Vue({
    router,
    vuetify,
}).$mount('#page-content');