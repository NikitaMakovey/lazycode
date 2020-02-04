import axios from 'axios';

export default {
    state: {
        authToken: localStorage.getItem('access_token') || null,
        user_id: localStorage.getItem('user_id') || null,
        username: localStorage.getItem('username') || null,
        name: localStorage.getItem('name') || null,
        is_admin: localStorage.getItem('is_admin') || null,
        specialization: localStorage.getItem('specialization') || null,
        email: localStorage.getItem('email') || null,
        image: localStorage.getItem('image') || null,
        about: localStorage.getItem('about') || null
    },
    getters: {
        ACCESS_TOKEN: state => { return state.authToken },
        USER_ID: state => { return state.user_id },
        USERNAME: state => { return state.username },
        NAME: state => { return state.name },
        IS_ADMIN: state => { return state.is_admin },
        SPECIALIZATION: state => { return state.specialization },
        EMAIL: state => { return state.email },
        IMAGE: state => { return state.image },
        ABOUT: state => { return state.about },
    },
    mutations: {
        SET_USER: (state, data) => {
            localStorage.setItem('user_id', data.user.id);
            localStorage.setItem('username', data.user.username);
            localStorage.setItem('name', data.user.name);
            localStorage.setItem('is_admin', data.user.is_admin);
            localStorage.setItem('specialization', data.user.specialization);
            localStorage.setItem('email', data.user.email);
            localStorage.setItem('image', data.user.image);
            localStorage.setItem('about', data.user.about);
            localStorage.setItem('access_token', data.access_token);
            state.authToken = data.access_token;
            state.user_id = data.user.id;
            state.username = data.user.username;
            state.name = data.user.name;
            state.is_admin = data.user.is_admin;
            state.specialization = data.user.specialization;
            state.email = data.user.email;
            state.image = data.user.image;
            state.about = data.user.about;
        },
        UNSET_USER: (state) => {
            localStorage.removeItem('access_token');
            localStorage.removeItem('user_id');
            localStorage.removeItem('username');
            localStorage.removeItem('name');
            localStorage.removeItem('is_admin');
            localStorage.removeItem('specialization');
            localStorage.removeItem('email');
            localStorage.removeItem('image');
            localStorage.removeItem('about');
            state.authToken = null;
            state.user_id = null;
            state.username = null;
            state.name = null;
            state.is_admin = null;
            state.specialization = null;
            state.email = null;
            state.image = null;
            state.about = null;
        },
    },
    actions: {
        LOGIN_USER(context, payload) {
            return new Promise(resolve => {
                context.commit('SET_USER', payload);
                resolve(payload);
            });
        },
        LOGOUT_USER(context) {
            axios.defaults.headers.common['Authorization'] = context.getters.ACCESS_TOKEN;

            if (context.getters.ACCESS_TOKEN !== null) {
                return new Promise((resolve, reject) => {
                    axios.get('/api/logout')
                        .then(response => {
                            context.commit('UNSET_USER');
                            delete axios.defaults.headers.common['Authorization'];
                            resolve(response);
                        })
                        .catch(error => {
                            reject(error)
                        });
                });
            }
        },
        RESET_EMAIL(context, payload) {

        },
    }
}
