<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
                <v-form @submit.prevent="loginSubmit">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <v-toolbar color="#393E41" dark flat>
                        <v-toolbar-title style="color: #F6F7EB !important;">Вход</v-toolbar-title>
                        <v-spacer/>
                    </v-toolbar>
                    <v-card-text>
                        <v-text-field
                            id="email" label="Ваша почта" v-model="email"
                            name="email" type="text" required autocomplete="email"/>
                        <v-text-field
                            id="password" label="Ваш пароль" v-model="password"
                            name="password" type="password" required autocomplete="new-password"/>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn class="mr-1" type="submit" style="background-color: #393E41; color: #F6F7EB !important;">Войти</v-btn>
                        <v-spacer/>
                        <router-link :to="{ name: 'auth.email' }" class="route__style route-link--color mr-1">
                            Забыли пароль?
                        </router-link>
                        <router-link :to="{ name: 'auth.register' }" class="route__style route-link--color">
                            Нет аккаунта?
                        </router-link>
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
                email: '',
                password: ''
            }
        },
        methods: {
            loginSubmit() {
                let data = { email: this.email, password: this.password };
                this.$store.dispatch('SIGN_IN', data)
                    .then(() => { this.$router.push('/')});
            }
        },
        computed: {
            csrf_token() {
                return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
            }
        }
    }
</script>
