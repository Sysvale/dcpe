import Vue from 'vue';
import VueRouter from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import Root from './Root';
import HomePage from './modules/home/pages/HomePage';

require('./bootstrap');

window.Vue = require('vue');

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes,
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(Root),
});
