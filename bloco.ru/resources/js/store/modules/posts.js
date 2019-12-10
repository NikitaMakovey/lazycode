import axios from 'axios';

export default {
    state: {
        posts: null,
        postComments: null
    },
    getters: {
        POSTS: state => { return state.posts },
        POST_COMMENTS: state => { return state.postComments }
    },
    mutations: {
        SET_POSTS: (state, payload) => {
            state.posts = payload;
        },
        SET_POST_COMMENTS: (state, payload) => {
            state.postComments = payload;
        }
    },
    actions: {
        GET_POSTS(context) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_POSTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_POST(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts/' + id;
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_POSTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_CATEGORY_POSTS(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/categories/' + id;
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_POSTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    })
            });
        },
        SET_POST(context, data) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts';
                axios.post(uri, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        UPDATE_POST(context, data, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts/' + id;
                axios.put(uri, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_POST_COMMENTS(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts/' + id + '/comments';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_POST_COMMENTS', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        DELETE_POST(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts/' + id;
                axios.delete(uri)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        }
    }
}
