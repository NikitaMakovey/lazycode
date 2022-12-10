export default {
    state: {
        processing: false,
        error: null
    },
    getters: {
        PROCESSING: (state) => state.processing,
        ERROR: (state) => state.error
    },
    mutations: {
        SET_PROCESSING(state, payload) {
            state.processing = payload;
        },
        SET_ERROR(state, payload) {
            state.error = payload;
        },
        CLEAN_ERROR(state) {
            state.error = null;
        }
    },
    actions: {

    }
}
