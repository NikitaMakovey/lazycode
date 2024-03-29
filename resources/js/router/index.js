import VueRouter from "vue-router";
import routes from "./routes";
import middlewarePipeline from "./middlewarePipeline";
import { store } from "../store";

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next();
    }
    const middleware = to.meta.middleware;
    const context = {to, from, next, store};
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1)
    });
});

export default router;
