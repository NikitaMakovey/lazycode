import axios from 'axios';

export default {
    state: {
        users: null,
        userPosts: null,
        userComments: null
    },
    getters: {
        USERS: state => { return state.users },
        USER_POSTS: state => { return state.userPosts },
        USER_COMMENTS: state => { return state.userComments }
    },
    mutations: {
        SET_USERS: (state, payload) => {
            state.users = payload;
        },
        SET_USER_POSTS: (state, payload) => {
            state.userPosts = payload;
        },
        SET_USER_COMMENTS: (state, payload) => {
            state.userComments = payload;
        }
    },
    actions: {
        GET_USERS(context) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/users';
                axios.get(uri)
                    .then(({data}) => {
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
                let uri = '/api/code/users/' + id;
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_USERS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_USER_POSTS(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/users/' + id + '/posts';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_USER_POSTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_USER_COMMENTS(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/users/' + id + '/comments';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_USER_COMMENTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        UPDATE_USER(context, data, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/users/' + id;
                axios.put(uri, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        }
    }
}
