export default function auth ({ next, store }) {
    if (!store.getters.AUTH_TOKEN) {
        return next({
            name: 'auth.login'
        });
    }
    return next();
}
