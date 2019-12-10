import axios from 'axios';

export default {
    state: {

    },
    getters: {

    },
    mutations: {

    },
    actions: {
        SET_COMMENT(context, data) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/comments';
                axios.post(uri, data)
                    .then(({data}) => {
                        resolve(data);
                    })
                    .catch(error => {
                        reject(error);
                    });
            });
        },
        DELETE_COMMENT(context, id) {
            return new Promise((resolve, reject) => {
                let uri = '/api/code/comments/' + id;
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
