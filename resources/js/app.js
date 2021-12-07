import Root from './Root';
import VueRouter from 'vue-router';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

import Cuida from '@sysvale/cuida';

import routes from './core/routes';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import { Vue } from 'vue-property-decorator';

import { HeaderTitle } from './core/common';

require('./bootstrap');
window.Vue = require('vue').default;

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.use(Cuida);

Vue.component('header-title', HeaderTitle);

const router = new VueRouter({
    mode: 'history',
    routes,
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(Root),
});
