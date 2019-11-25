import axios from "axios";
import { app } from "../app";

let token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');

const instance = axios.create({
    baseURL: '/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token
    }
});

instance.interceptors.response.use(
    response => { return response },
    error => {
        if (error.response.status === 401) { app.$router.push({ name: 'auth.login' }) }
        else if (error.response.status === 422) { app.$router.push({ name: 'notfound' }) }
        else { console.error(error) }
        return Promise.reject(error);
    }
);

export default instance;
