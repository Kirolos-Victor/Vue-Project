/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');
import Donut from 'vue-css-donut-chart';
import 'vue-css-donut-chart/dist/vcdonut.css';

Vue.use(Donut);
import Chartkick from 'vue-chartkick'
import Chart from 'chart.js'

Vue.use(Chartkick.use(Chart));
//registertion
Vue.component(
    'register',
    require('./components/Register.vue').default
);
//Gate
import Gate from "./Gate";
//window.user we get user from Master layout
Vue.prototype.$gate= new Gate(window.user);
//passport authentication package
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
//not found page global
Vue.component('not-found',require('./components/NotFound.vue').default
);
// pagination package
Vue.component('pagination', require('laravel-vue-pagination'));
//chat component
Vue.component('messenger-chat',require('./components/front/messenger-chat.vue').default
);

// moment package
import moment from "moment";
Vue.filter('msgTime',function (value) {
    return moment(value,['HH:mm,dd,dd']).format("hh:mm a Do MMMM");
});
Vue.filter('date',function (value) {
    return moment(value).format("MMMM Do YYYY");
});
Vue.filter('hour',function (value) {
    return moment(value).add(2,'hours').fromNow();          // in 21 hours
    //moment(value).add(2,'hours').format('LT');   // 2:41 AM
});
// progress animation bar package
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});
// sweet alert package
import Swal from 'sweetalert2'
// we use window to disply this function everywhere (globaly)
window.swal = Swal ;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});
window.Toast= Toast;

//toggle button
import ToggleButton from 'vue-js-toggle-button'

Vue.use(ToggleButton);
// validation form package
import { Form, HasError, AlertError } from 'vform'
window.Form= Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
//infinity loading package
Vue.component('InfiniteLoading', require('vue-infinite-loading'));

// axios package
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.use(VueAxios , axios);
//chat scroller
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll);

// Vue Router package SO IMPORTANT
import VueRouter from 'vue-router'
window.VueRouter= VueRouter;
 Vue.use(VueRouter);
let routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/developer', component: require('./components/Developers.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/user', component: require('./components/Users.vue').default },
    { path: '/governorate', component: require('./components/Governorate.vue').default },
    { path: '/city', component: require('./components/City.vue').default },
    { path: '/product', component: require('./components/Product.vue').default },
    { path: '/orders', component: require('./components/Orders.vue').default },
    { path: '/category', component: require('./components/Category.vue').default },



    //using * so when you type a different url that doesnt exist it will return you not found page
    // its must be the last route
    { path: '*', component: require('./components/NotFound.vue').default },
];
const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
});
//filter uppercase
Vue.filter('upText',function (value) {
    return value.charAt(0).toUpperCase() + value.slice(1)
});
// making a http request after submiting a form
// Important note you should check laravel echo + pusher for better performance
let Fire= new Vue();
window.Fire= Fire ;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('post', require('./components/front/Post.vue').default);
Vue.component('comments', require('./components/front/Comment.vue').default);
Vue.component('comment-input', require('./components/front/commentInput.vue').default);
Vue.component('replies', require('./components/front/Reply.vue').default);
Vue.component('item', require('./components/front/Item.vue').default);
Vue.component('nav-bar-cart', require('./components/front/NavBarCart.vue').default);
Vue.component('notify-bill', require('./components/front/notifcation-bell.vue').default);
Vue.component('survey-question', require('./components/front/Question.vue').default);
Vue.component('answer-chart', require('./components/AnswerChart.vue').default);
Vue.component('todo-component', require('./components/front/todoApp.vue').default);

//IMPORTANT NOTE you only need to register component here if you are going to use it
// as element in laravel blade layout BUT IN vue you can call component by its name without registering it
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
});
