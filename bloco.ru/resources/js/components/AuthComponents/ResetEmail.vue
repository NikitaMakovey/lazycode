<template>
    <v-row align="center" justify="center" class="ma-0">
        <v-col cols="12" sm="8" md="6" lg="4" xl="2" class="pa-0">
            <v-card class="elevation-12">
                <v-form @submit.prevent="resetEmailSubmit">
                    <input type="hidden" name="_token" :value="csrf_token">
                    <v-toolbar color="#393E41" dark flat class="toolbar-container">
                        <v-toolbar-title class="header-title-auth-text">Восстановление пароля</v-toolbar-title>
                        <v-spacer/>
                    </v-toolbar>
                    <v-card-text>
                        <div class="form-group">
                            <p style="font-size: 1rem; color: #393E41">{{ message }}</p>
                        </div>
                        <div class="form-group">
                            <label for="email">Ваш e-mail</label>
                            <input
                                v-model="form.email" type="email" name="email" id="email"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }"
                                required autocomplete="email"
                            >
                            <has-error :form="form" field="email"></has-error>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn type="submit" class="mr-1 submit-auth-button">Отправить</v-btn>
                        <v-spacer/>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'ResetEmail',
        data() {
            return {
                form: new Form({
                    email: ''
                }),
                message: ''
            }
        },
        methods: {
            resetEmailSubmit() {
                let url = '/api/reset/email';
                this.form.post(url).then(({data}) => {
                    this.message = data.message;
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
