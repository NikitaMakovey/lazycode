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
        },
        SET_POST: (state, payload) => {
            state.posts = payload;
            localStorage.setItem('P_TITLE', payload[0].post_title);
            localStorage.setItem('P_CATEGORY_ID', payload[0].category_id);
            localStorage.setItem('P_CATEGORY', payload[0].category);
            localStorage.setItem('P_BODY', payload[0].post_body);
        },
        ADD_COMMENT: (state, payload) => {
            let comment = {
                id : payload.data.id,
                created_at : Date.now(),
                user_id : payload.data.author_id,
                username : payload.udata.username,
                user_image : payload.udata.user_image,
                comment_body : payload.data.body,
                rating : 0
            };
            console.log(comment);
            state.postComments.push(comment);
        },
        REMOVE_COMMENT: (state, payload) => {
            state.postComments = state.postComments.filter(x => x.id !== payload);
        }
    },
    actions: {
        SET_COMMENT(context, data) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/comments';
                axios.post(uri, data.data)
                    .then((post_data) => {
                        console.log(post_data);
                        context.commit('ADD_COMMENT', { data : post_data.data, udata : data.udata });
                        resolve(post_data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        DELETE_COMMENT(context, id) {
            return new Promise((resolve, reject) => {
                context.commit('REMOVE_COMMENT', id);
                let uri = '/api/code/comments/' + id;
                axios.delete(uri)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
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
                        context.commit('SET_POST', data);
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
        UPDATE_POST(context, data) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/posts/' + data.id;
                axios.put(uri, data.data)
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
