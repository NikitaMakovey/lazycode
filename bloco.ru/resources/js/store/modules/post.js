import axios from 'axios';

export default {
    state: {
        POST: null,
        POST_COMMENTS: null,
        COUNT_COMMENTS: null,
        SUM_VOTES: null,
        POST_TAGS: null,
        CLICKED: 0
    },
    getters: {
        POST: state => { return state.POST },
        POST_COMMENTS: state => { return state.POST_COMMENTS },
        POST_TAGS: state => { return state.POST_TAGS },
        COUNT_COMMENTS: state => { return state.COUNT_COMMENTS },
        SUM_VOTES: state => { return state.SUM_VOTES },
        CLICKED: state => { return state.CLICKED },
    },
    mutations: {
        SET_POST: (state, payload) => {
            state.POST = payload.post;
            state.POST_COMMENTS = payload.comments;
            state.POST_TAGS = payload.tags;
            state.COUNT_COMMENTS = payload.post.count_comments;
            state.SUM_VOTES = payload.post.sum_votes;
        },
        SET_CLICKED: (state, payload) => {
            state.CLICKED = payload;
        },
        UPDATE_CC: (state) => {
            state.COUNT_COMMENTS++;
        },
        UPDATE_SV: (state, payload) => {
            state.SUM_VOTES = payload.sum_votes;
            state.CLICKED = payload.code;
        },
        UPDATE_CSV: (state, payload) => {
            for (let i = 0; i < state.POST_COMMENTS.length; i++) {
                if (state.POST_COMMENTS[i].id == payload.id) {
                    state.POST_COMMENTS[i].sum_votes = payload.sum_votes;
                    state.POST_COMMENTS[i].code = payload.code;
                    break;
                }
            }
        },
        ADD_COMMENT: (state, payload) => {
            state.POST_COMMENTS.push(payload.comment);
        },
        REMOVE_COMMENT: (state, payload) => {
            state.POST_COMMENTS = state.POST_COMMENTS.filter(x => x.id !== payload);
            state.COUNT_COMMENTS--;
        }
    },
    actions: {
        POST_COMMENT(context, data) {
            return new Promise(resolve => {
                context.commit('ADD_COMMENT', data);
                resolve(data);
            });
        },
        DELETE_COMMENT(context, id) {
            return new Promise(resolve => {
                context.commit('REMOVE_COMMENT', id);
                resolve(id);
            });
        },
        GET_POST(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/posts/' + id;
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
        GET_AUTH_POST(context, payload) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/auth-posts/' + payload.id;
                axios.get(uri, payload.config)
                    .then(({data}) => {
                        context.commit('SET_POST', data);
                        context.commit('SET_CLICKED', data.clicked);
                        resolve(data);
                    })
                    .catch(() => {
                        let uri = '/api/v1/posts/' + payload.id;
                        axios.get(uri)
                            .then(({data}) => {
                                context.commit('SET_POST', data);
                                resolve(data);
                            })
                            .catch(error => {
                                reject(error);
                            });
                    });
            });
        },
        UPDATE_POST_VOTES(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_SV', payload);
                resolve(payload);
            });
        },
        UPDATE_POST_COMMENTS(context) {
            return new Promise(resolve => {
                context.commit('UPDATE_CC');
                resolve(1);
            });
        },
        UPDATE_COMMENT_VOTES(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_CSV', payload);
                resolve(payload);
            });
        },
    }
}
