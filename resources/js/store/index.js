import Vue from 'vue';
import Vuex from 'vuex';
import auth from './modules/auth';
import user from './modules/user';
import post from './modules/post';
import comment from './modules/comment';
import category from "./modules/category";
import lab from "./modules/lab";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        auth,
        user,
        post,
        comment,
        category,
        lab
    }
});
