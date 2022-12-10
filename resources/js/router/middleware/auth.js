export default function auth ({ next, store }) {
    if (store.getters.ACCESS_TOKEN == undefined || store.getters.ACCESS_TOKEN == null) {
        return next({
            name: 'auth.login'
        });
    }
    return next();
}
