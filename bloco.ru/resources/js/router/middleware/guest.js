export default function guest ({ next, store }) {
    if (store.getters.AUTH_TOKEN) {
        return next({
            name: 'main'
        });
    }
    return next();
}
