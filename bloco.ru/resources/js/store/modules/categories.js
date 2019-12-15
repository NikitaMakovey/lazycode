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
                let uri = '/api/code/categories';
                axios.get(uri)
                    .then(({data}) => {
                        context.commit('SET_CATEGORIES', data);
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        }
    }
}
