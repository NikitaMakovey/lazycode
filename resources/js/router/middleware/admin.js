export default function admin ({ from, next, store }) {
    if (!store.getters.IS_ADMIN) {
        return from();
    }
    return next();
}
