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
        AUTH_TOKEN: state => { return state.authToken },
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
            localStorage.setItem('user_id', data.id);
            localStorage.setItem('username', data.username);
            localStorage.setItem('name', data.name);
            localStorage.setItem('is_admin', data.is_admin);
            localStorage.setItem('specialization', data.specialization);
            localStorage.setItem('email', data.email);
            localStorage.setItem('image', data.image);
            localStorage.setItem('about', data.about);
            state.user_id = data.id;
            state.username = data.username;
            state.name = data.name;
            state.is_admin = data.is_admin;
            state.specialization = data.specialization;
            state.email = data.email;
            state.image = data.image;
            state.about = data.about;
        },
        UNSET_AUTH: (state) => {
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
        SET_TOKEN: (state, token) => {
            localStorage.setItem('access_token', token);
            state.authToken = token;
        }
    },
    actions: {
        SIGN_UP(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/register', payload)
                    .then(response => {
                        const token = response.data.token;
                        const user_data = response.data.data;
                        context.commit('SET_TOKEN', token);
                        context.commit('SET_USER', user_data);
                        resolve(response);
                    })
                    .catch(error => { reject(error) });
            });
        },
        SIGN_IN(context, payload) {
            return new Promise((resolve, reject) => {
                axios.post('/api/login', payload)
                    .then(response => {
                        const token = response.data.token;
                        const user_data = response.data.data;
                        context.commit('SET_TOKEN', token);
                        context.commit('SET_USER', user_data);
                        resolve(response);
                    })
                    .catch(error => { reject(error) });
            });
        },
        SIGN_OUT(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.getters.AUTH_TOKEN;

            if (context.getters.AUTH_TOKEN !== null) {
                return new Promise((resolve, reject) => {
                    axios.post('http://localhost:8000/api/logout')
                        .then(response => {
                            context.commit('UNSET_AUTH');
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
        RESET_PASSWORD(context, payload) {

        }
    }
}
