<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
                <v-form @submit.prevent="registerSubmit">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <v-toolbar color="#393E41" dark flat>
                        <v-toolbar-title style="color: #F6F7EB !important;">Регистрация</v-toolbar-title>
                        <v-spacer/>
                    </v-toolbar>
                    <v-card-text>
                        <v-text-field
                            id="name" label="Ваше имя" v-model="name"
                            name="name" type="text" required autocomplete="name"/>
                        <v-text-field
                            id="username" label="Никнейм" v-model="username"
                            name="username" type="text" required autocomplete="username"/>
                        <v-text-field
                            id="email" label="Ваша почта" v-model="email"
                            name="email" type="text" required autocomplete="email"/>
                        <v-text-field
                            id="password" label="Ваш пароль" v-model="password"
                            name="password" type="password" required autocomplete="new-password"/>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn type="submit"
                               style="background-color: #393E41; color: #F6F7EB !important;">Зарегистрироваться</v-btn>
                        <v-spacer/>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "Register",
        data() {
            return {
                name: '',
                username: '',
                email: '',
                password: ''
            }
        },
        methods: {
            registerSubmit() {
                let data = {
                    name: this.name,
                    username: this.username,
                    email: this.email,
                    password: this.password
                };
                this.$store.dispatch('SIGN_UP', data)
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
