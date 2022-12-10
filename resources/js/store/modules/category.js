import axios from 'axios';

export default {
    state: {
        CATEGORIES: null,
        RATING: null
    },
    getters: {
        CATEGORIES: state => { return state.CATEGORIES },
        RATING: state => { return state.RATING }
    },
    mutations: {
        SET_CATEGORIES: (state, payload) => {
            state.CATEGORIES = payload;
        },
        SET_RATING: (state, payload) => {
            state.RATING = payload;
        }
    },
    actions: {
        GET_CATEGORIES(context) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/categories';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_CATEGORIES', data.categories);
                        resolve(data.categories);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        GET_RATING(context) {
            return new Promise((resolve, reject) => {
                let uri = '/api/v1/rating';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_RATING', data.categories);
                        resolve(data.categories);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        }
    }
}
