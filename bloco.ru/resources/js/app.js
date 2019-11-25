require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
import vuetify from "./config/vuetify";
import Vuelidate from "vuelidate";
import { store } from "./store";
import router from "./router/index";
import App from "./Index";
import { Form, HasError, AlertError } from 'vform';

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(VueRouter);
Vue.use(Vuelidate);

export const app = new Vue({
    el: '#app',
    render: h => h(App),
    router: router,
    store: store,
    vuetify
});
