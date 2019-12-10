import axios from 'axios';

export default {
    state: {

    },
    getters: {

    },
    mutations: {

    },
    actions: {
        SET_VOTE(context, data) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/votes';
                axios.post(uri, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        DELETE_VOTE(context, data) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/votes/delete';
                axios.post(uri, data)
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
