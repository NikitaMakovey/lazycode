export default {
    state: {
        CHANNELS: null
    },
    getters: {
        CHANNELS: state => { return state.CHANNELS }
    },
    mutations: {
        REFRESH_CHANNELS: (state, payload) => {
            state.CHANNELS = payload;
        }
    },
    actions: {
        UPDATE_CHANNELS(context, data) {
            return new Promise(resolve => {
                context.commit('REFRESH_CHANNELS', data);
                resolve(data);
            });
        }
    }
}
