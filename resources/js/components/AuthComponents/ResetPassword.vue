<template>
    <v-app id="inspire" class="auth-background">
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center" class="ma-0">
                    <v-col cols="12" sm="8" md="6" lg="4" xl="2" class="pa-0">
                        <v-card class="elevation-12">
                            <template v-if="message === ''">
                                <v-form @submit.prevent="resetPasswordSubmit">
                                    <input type="hidden" name="token" :value="csrf_token">
                                    <v-toolbar color="#393E41" dark flat>
                                        <v-toolbar-title style="color: #F6F7EB !important;">Смена пароля</v-toolbar-title>
                                        <v-spacer/>
                                    </v-toolbar>
                                    <v-card-text>
                                        <div class="form-group">
                                            <label for="password">Ваш пароль</label>
                                            <input
                                                v-model="form.password" type="password" name="password" id="password"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"
                                                required autocomplete="password"
                                            >
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Повторите пароль</label>
                                            <input
                                                v-model="form.password_confirmation" type="password" name="password_confirmation"
                                                id="password_confirmation"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                                                required autocomplete="password"
                                            >
                                            <has-error :form="form" field="password_confirmation"></has-error>
                                        </div>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn type="submit"
                                               style="background-color: #393E41; color: #F6F7EB !important;"
                                        >
                                            Сменить пароль
                                        </v-btn>
                                        <v-spacer/>
                                    </v-card-actions>
                                </v-form>
                            </template>
                            <template v-else-if="message == 403">
                                <v-toolbar color="#393E41" dark flat>
                                    <v-toolbar-title style="color: #F6F7EB !important;">Смена пароля</v-toolbar-title>
                                    <v-spacer/>
                                </v-toolbar>
                                <v-card-text>
                                    <div class="text-center">
                                        <span class="title">
                                            Невозможно сменить пароль!
                                        </span>
                                    </div>
                                </v-card-text>
                            </template>
                            <template v-else>
                                <v-toolbar color="#393E41" dark flat>
                                    <v-toolbar-title style="color: #F6F7EB !important;">Смена пароля</v-toolbar-title>
                                    <v-spacer/>
                                </v-toolbar>
                                <v-card-text>
                                    <div class="text-center">
                                        <span class="title">
                                            {{ message }}
                                        </span>
                                    </div>
                                </v-card-text>
                            </template>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: 'ResetPassword',
        data() {
            return {
                form: new Form({
                    password: '',
                    password_confirmation: '',
                    code: this.$route.params.code,
                    token: this.$route.params.token
                }),
                message: ''
            }
        },
        methods: {
            resetPasswordSubmit() {
                let url = '/api/reset/password';
                const Router = this.$router;
                this.form.post(url).then(({data}) => {
                    this.message = data.message;
                    setTimeout(function () {
                        Router.push({ name: 'auth.login' });
                    }, 3000)
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
    .auth-background {
        background-color: #4158D0;
        background-image: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
    }
</style>
