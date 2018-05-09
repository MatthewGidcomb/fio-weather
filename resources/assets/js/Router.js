import VueRouter from 'vue-router';

// components
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import Home from './components/Home.vue';

const router = new VueRouter({
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

export default router;
