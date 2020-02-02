<template>
    <v-row align="center" justify="center" class="ma-0">
        <v-col cols="12" sm="8" md="6" lg="4" xl="2" class="pa-0">
            <v-card class="elevation-12">
                <v-form @submit.prevent="loginSubmit">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <v-toolbar color="#393E41" dark flat class="toolbar-container">
                        <v-toolbar-title class="header-title-auth-text">Вход</v-toolbar-title>
                        <v-spacer/>
                    </v-toolbar>
                    <v-card-text>
                        <div class="form-group">
                            <label for="email">Ваша почта</label>
                            <input
                                v-model="form.email" type="email" name="email" id="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"
                                required autocomplete="email"
                            >
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label for="password">Ваш пароль</label>
                            <input
                                v-model="form.password" type="password" name="password" id="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                required autocomplete="password"
                            >
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div>
                            <v-checkbox
                                v-model="form.remember_me"
                                label="Запомнить меня"
                            ></v-checkbox>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn class="mr-1 submit-auth-button" type="submit">Войти</v-btn>
                        <div class="xs-login-block-container">
                            <div class="xs-login-block">
                                <router-link :to="{ name: 'auth.email' }" class="route__style route-link--color mr-1">
                                    Забыли пароль?
                                </router-link>
                            </div>
                            <div class="xs-login-block">
                                <router-link :to="{ name: 'auth.register' }" class="route__style route-link--color">
                                    Нет аккаунта?
                                </router-link>
                            </div>
                        </div>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                form: new Form({
                    email: '',
                    password: '',
                    remember_me: false
                })
            }
        },
        methods: {
            loginSubmit() {
                let url = '/api/login';
                this.form.post(url).then(({data}) => {
                    this.$store.dispatch('LOGIN_USER', data)
                        .then(() => { this.$router.push('/')});
                });
            }
        },
        computed: {
            csrf_token() {
                return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
            }
        }
    }
</script>

<style scoped>
    .header-title-auth-text {
        color: #F6F7EB !important;
    }
    .submit-auth-button {
        background-color: #393E41 !important;
        color: #F6F7EB !important;
    }
    .xs-login-block {
        display: inline-block;
    }
    .xs-login-block-container {
        margin-left: auto;
        margin-right: auto;
    }
    @media screen and (max-width: 320px) {
        .xs-login-block a {
            font-size: 0.8rem;
        }
    }
    @media screen and (min-width: 600px) and (max-width: 960px) {
        .xs-login-block a {
            font-size: 1rem;
        }
        .header-title-auth-text {
            font-size: 1.1rem !important;
        }
        .submit-auth-button {
            font-size: 1.1rem;
        }
    }
    @media screen and (min-width: 961px) and (max-width: 1264px) {
        .xs-login-block a {
            font-size: 1.0rem;
        }
        .header-title-auth-text {
            font-size: 1.3rem !important;
        }
        .submit-auth-button {
            font-size: 1.15rem;
        }
    }
    @media screen and (min-width: 1265px) {
        .xs-login-block a {
            font-size: 1.0rem;
        }
        .header-title-auth-text {
            font-size: 1.5rem !important;
        }
        .submit-auth-button {
            font-size: 1rem;
        }
    }
</style>
