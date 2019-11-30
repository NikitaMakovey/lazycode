import axios from 'axios';

export default {
    state: {
        users: []
    },
    getters: {
        USERS: state => { return state.users },
        USER: state => id => { return state.users.find(user => user.id === id) }
    },
    mutations: {
        SET_USERS: (state, data) => {
            state.users = data;
        }
    },
    actions: {
        GET_USERS(context) {
            return new Promise((resolve, reject) => {
                axios.get('/api/lazycode/users')
                    .then(([data]) => {
                        context.commit('SET_USERS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_USER(context, id) {
            return new Promise((resolve, reject) => {
                axios.get('/api/lazycode/users/' + id)
                    .then(([data]) => {
                        context.commit('SET_USERS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        UPDATE_USER(context, data, id) {
            return new Promise((resolve, reject) => {
                axios.patch('/api/lazycode/users/' + id)
                    .then(() => {
                        resolve(1);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        }
    }
}
