import Vue from 'vue';
import Router from 'vue-router';
import Login from './components/Login';
import Register from './components/Register';
import Dashboard from "./components/Dashboard";
import EmailVerified from "./components/EmailVerified";

Vue.use(Router);

export const router = new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/verify',
            name: 'verify',
            component: EmailVerified
        },
        {path: "*", component: Login}
    ]
});

router.beforeEach((to, from, next) => {
    const publicPages = ['/', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('user');
    if (authRequired && !loggedIn) {
        next('/');
    } else {
        next();
    }
});