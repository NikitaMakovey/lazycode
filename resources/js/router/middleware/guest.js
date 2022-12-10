export default function guest ({ next, store }) {
    if (store.getters.ACCESS_TOKEN != undefined && store.getters.ACCESS_TOKEN != null) {
        return next({
            name: 'main'
        });
    }
    return next();
}
