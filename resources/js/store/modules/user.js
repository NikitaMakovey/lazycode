import axios from 'axios';

export default {
    state: {
        USER: null,
        USER_POSTS: null,
        USER_COMMENTS: null
    },
    getters: {
        USER: state => { return state.USER },
        USER_POSTS: state => { return state.USER_POSTS },
        USER_COMMENTS: state => { return state.USER_COMMENTS }
    },
    mutations: {
        SET_USER: (state, payload) => {
            state.USER = payload.user;
        },
        SET_USER_POSTS: (state, payload) => {
            state.USER_POSTS = payload;
        },
        SET_USER_COMMENTS: (state, payload) => {
            state.USER_COMMENTS = payload;
        }
    },
    actions: {
        GET_USER(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/users/' + id;
                axios.get(uri)
                    .then(({data}) => {
                        console.log(data);
                        context.commit('SET_USER', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_USER_POSTS(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/users/' + id + '/posts';
                axios.get(uri)
                    .then((data) => {
                        context.commit('SET_USER_POSTS', data.posts);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_USER_COMMENTS(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/users/' + id + '/comments';
                axios.get(uri)
                    .then((data) => {
                        context.commit('SET_USER_COMMENTS', data.data.comments);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        }
    }
}
