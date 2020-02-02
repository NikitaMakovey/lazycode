import axios from 'axios';

export default {
    state: {
        categories: null
    },
    getters: {
        CATEGORIES: state => { return state.categories },
    },
    mutations: {
        SET_CATEGORIES: (state, payload) => {
            state.categories = payload;
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
        }
    }
}
