import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import 'bootstrap';

import App from './App.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Home from './components/Home.vue';

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
axios.defaults.baseURL = 'http://fio-weather.test/api';

// vue-auth requires `Vue.router` to be set to the router instance
// TODO: move router to its own file
const router = Vue.router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
            meta: { auth: true }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: { auth: false }
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: { auth: false }
        }
    ]
});

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
 });

const app = new Vue({
    el: '#app',
    router: router,
    render: (app) => app(App)
});
