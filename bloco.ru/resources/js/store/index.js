import Vue from 'vue';
import Vuex from 'vuex';
import user from './modules/user';
import users from './modules/users';
import posts from './modules/posts';
import comments from './modules/comments';
import votes from './modules/votes';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        user,
        users,
        posts,
        comments,
        votes
    }
});
