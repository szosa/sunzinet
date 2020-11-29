import Vue from 'vue'
import App from './App.vue'
import {router} from "./router";
import store from './store';
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import api from './plugins/api'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import {ValidationProvider} from 'vee-validate';

Vue.config.productionTip = false;

Vue.component('ValidationProvider', ValidationProvider);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);


Vue.prototype.$http = api;
api.defaults.timeout = 10000;

api.interceptors.response.use(
    response => {
        if (response.status === 200 || response.status === 201) {
            return Promise.resolve(response);
        } else {
            return Promise.reject(response);
        }
    },
    error => {
        if (error.response.status) {
            switch (error.response.status) {
                case 401:
                    localStorage.removeItem('user');
                    router.replace({
                        path: "/",
                        query: {redirect: router.currentRoute.fullPath}
                    });
                    break;
                case 403:
                    localStorage.removeItem('user');
                    router.replace({
                        path: "/",
                        query: {redirect: router.currentRoute.fullPath}
                    });
                    break;
                case 404:
                    alert('Nie znaleziono zasobu');
                    break;
                case 502:
                    setTimeout(() => {
                        router.replace({
                            path: "/",
                            query: {
                                redirect: router.currentRoute.fullPath
                            }
                        });
                    }, 1000);
            }
            return Promise.reject(error.response);
        }
    }
);
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
