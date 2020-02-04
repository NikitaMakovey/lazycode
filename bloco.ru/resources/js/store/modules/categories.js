import axios from 'axios';

export default {
    state: {
        categories: null,
        rating: null
    },
    getters: {
        CATEGORIES: state => { return state.categories },
        RATING: state => { return state.rating }
    },
    mutations: {
        SET_CATEGORIES: (state, payload) => {
            state.categories = payload;
        },
        SET_RATING: (state, payload) => {
            state.rating = payload;
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
