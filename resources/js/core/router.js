import VueRouter from 'vue-router';

let routes = [
    {
        name: 'Login',
        path: '/auth/login',
        component: require('../pages/auth/LoginPage').default
    },
    {
        name: 'Home',
        path: '/',
        component: require('../pages/HomePage').default,
        options: {
            redirectAfterLogin: true
        }
    },
    {
        name: 'Report',
        path: '/report',
        component: require('../pages/ReportPage').default
    },

];

Vue.use(VueRouter);


export default new VueRouter({
    mode: 'history',
    routes,
});