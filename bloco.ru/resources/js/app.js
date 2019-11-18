/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');

import VueRouter from "vue-router";
import Vue from "vue";
import Vuex from "vuex";
import Axios from "axios";
import Main from "./components/posts/MainPage";
import Post from "./components/posts/Post";
import CreatePostPage from "./components/posts/CreatePostPage";
import EditPostPage from "./components/posts/EditPostPage";
import IndexUserPage from "./components/users/IndexUserPage";
import User from "./components/users/User";
import EditUserPage from "./components/users/EditUserPage";
import { Form, HasError, AlertError } from 'vform';

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(VueRouter);

Vue.use(Vuex);

let routes = [
    { path: '/', component: Main },
    { path: '/posts/create', name: 'posts.create', component:  CreatePostPage },
    { path: '/posts/:id/edit', name: 'posts.edit', component:  EditPostPage },
    { path: '/posts/:id', name: 'post', component: Post },
    { path: '/users', name: 'users', component: IndexUserPage },
    { path: '/users/:id', name: 'user', component: User },
    { path: '/users/:id/edit', name: 'users.edit', component: EditUserPage }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
});

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
