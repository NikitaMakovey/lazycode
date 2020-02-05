import axios from 'axios';

export default {
    state: {
        ACCESS_TOKEN: localStorage.getItem('ACCESS_TOKEN') || null,
        EXPIRES_AT: localStorage.getItem('EXPIRES_AT') || null,
        ID: localStorage.getItem('ID') || null,
        USERNAME: localStorage.getItem('USERNAME') || null,
        NAME: localStorage.getItem('NAME') || null,
        IS_ADMIN: localStorage.getItem('IS_ADMIN') || null,
        IMAGE: localStorage.getItem('IMAGE') || null
    },
    getters: {
        ACCESS_TOKEN: state => { return state.ACCESS_TOKEN },
        EXPIRES_AT: state => { return state.EXPIRES_AT },
        ID: state => { return state.ID },
        USERNAME: state => { return state.USERNAME },
        NAME: state => { return state.NAME },
        IS_ADMIN: state => { return state.IS_ADMIN },
        IMAGE: state => { return state.IMAGE },
    },
    mutations: {
        SET_USER: (state, data) => {
            localStorage.setItem('ACCESS_TOKEN', data.access_token);
            localStorage.setItem('EXPIRES_AT', data.expires_at);
            localStorage.setItem('ID', data.user.id);
            localStorage.setItem('USERNAME', data.user.username);
            localStorage.setItem('NAME', data.user.name);
            localStorage.setItem('IS_ADMIN', data.user.is_admin);
            localStorage.setItem('IMAGE', data.user.image);
            state.ACCESS_TOKEN = data.access_token;
            state.EXPIRES_AT = data.expires_at;
            state.ID = data.user.id;
            state.USERNAME = data.user.username;
            state.NAME = data.user.name;
            state.IS_ADMIN = data.user.is_admin;
            state.IMAGE = data.user.image;
        },
        UNSET_USER: (state) => {
            localStorage.removeItem('ACCESS_TOKEN');
            localStorage.removeItem('EXPIRES_AT');
            localStorage.removeItem('ID');
            localStorage.removeItem('USERNAME');
            localStorage.removeItem('NAME');
            localStorage.removeItem('IS_ADMIN');
            localStorage.removeItem('IMAGE');
            state.ACCESS_TOKEN = null;
            state.EXPIRES_AT = null;
            state.ID = null;
            state.USERNAME = null;
            state.NAME = null;
            state.IS_ADMIN = null;
            state.IMAGE = null;
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
