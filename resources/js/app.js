
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import router from './core/router';
import store from './core/store';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';
import 'babel-polyfill';

import Layout from './layouts/default';



/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');


window.axios = require('axios');
window.axios.defaults.baseURL = '/api/v0.01';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
if (!token) {
    if (!redirectIfNotAtLoginPage()) {
        init();
    }
} else {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    init();
}


function redirectIfNotAtLoginPage() {
    if (!!window.location.pathname.search( /\/auth\/.*/ )) {
        window.location.href = '/auth/login';
        return true;
    }
    return false;
}

function init() {
    window.axios.interceptors.response.use(null, function(error) {
        if (error.response.status === 401) {
            redirectIfNotAtLoginPage();
        }
        return Promise.reject(error);
    });

    window.Vue.use(BootstrapVue);
    window.Vue.mixin({
        components: {
            [Layout.name]: Layout
        },
        computed: {
            layout: () => {
                return Layout.name;
            }
        }
    });

    window.app = new window.Vue({
        router,
        store
    }).$mount('#app');
}


