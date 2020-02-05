import axios from 'axios';

export default {
    state: {
        POST: null,
        POST_COMMENTS: null,
        COUNT_COMMENTS: null,
        SUM_VOTES: null
    },
    getters: {
        POST: state => { return state.POST },
        POST_COMMENTS: state => { return state.POST_COMMENTS },
        COUNT_COMMENTS: state => { return state.COUNT_COMMENTS },
        SUM_VOTES: state => { return state.SUM_VOTES }
    },
    mutations: {
        SET_POST: (state, payload) => {
            state.POST = payload.post;
            state.POST_COMMENTS = payload.comments;
            state.COUNT_COMMENTS = payload.post.count_comments;
            state.SUM_VOTES = payload.post.sum_votes;
        },
        UPDATE_CC: (state, payload) => {
            state.COUNT_COMMENTS = payload;
        },
        UPDATE_SV: (state, payload) => {
            state.SUM_VOTES = payload;
        },
        UPDATE_CSV: (state, payload) => {
            for (let i = 0; i < state.POST_COMMENTS.length; i++) {
                if (state.POST_COMMENTS[i].id == payload.id) {
                    state.POST_COMMENTS[i].sum_votes = payload.sum_votes;
                    break;
                }
            }
        },
        ADD_COMMENT: (state, payload) => {
            // let comment = {
            //     id : payload.data.id,
            //     created_at : Date.now(),
            //     author_id : payload.data.author_id,
            //     username : payload.udata.username,
            //     user_image : payload.udata.user_image,
            //     body : payload.data.body,
            //     rating : 0
            // };
            state.POST_COMMENTS.push(payload.comment);
        },
        REMOVE_COMMENT: (state, payload) => {
            state.POST_COMMENTS = state.POST_COMMENTS.filter(x => x.id !== payload);
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
        UPDATE_POST_VOTES(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_SV', payload);
                resolve(payload);
            });
        },
        UPDATE_POST_COMMENTS(context, payload) {
            return new Promise(resolve => {
                context.commit('UPDATE_CC', payload);
                resolve(payload);
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
