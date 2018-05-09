import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import 'bootstrap';
import { configureAxios } from './utils';

import App from './App.vue';
import router from './Router.js'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
configureAxios(axios);
// vue-auth requires `Vue.router` to be set to the router instance
Vue.router = router;

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
