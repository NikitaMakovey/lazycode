require('./bootstrap');

import Vue from "vue";
import VueRouter from "vue-router";
import vuetify from "./config/vuetify";
import { store } from "./store";
import router from "./router/index";
import App from "./Index";
import { Form, HasError, AlertError, AlertErrors } from 'vform';
import VueQuillEditor from 'vue-quill-editor';

import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';

Vue.use(VueQuillEditor);

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.use(VueRouter);

const moment = require('moment');
require('moment/locale/ru');

Vue.use(require('vue-moment'), {
    moment
});

export const app = new Vue({
    el: '#app',
    render: h => h(App),
    router: router,
    store: store,
    vuetify
});
