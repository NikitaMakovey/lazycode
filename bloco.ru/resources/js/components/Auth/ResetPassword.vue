<template>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
                <v-form @submit.prevent="resetPasswordSubmit">
                    <input type="hidden" name="token" :value="csrf_token">
                    <v-toolbar color="#393E41" dark flat>
                        <v-toolbar-title style="color: #F6F7EB !important;">Смена пароля</v-toolbar-title>
                        <v-spacer/>
                    </v-toolbar>
                    <v-card-text>
                        <v-text-field
                            id="email" label="Ваша почта" v-model="email"
                            name="email" type="text" required autocomplete="email"/>
                        <v-text-field
                            id="password" label="Ваш пароль" v-model="password"
                            name="password" type="password" required autocomplete="new-password"/>
                        <v-text-field
                            id="password-confirm" label="Пароль ещё раз" v-model="password_confirmation"
                            name="password_confirmation" type="password" required autocomplete="new-password"/>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn type="submit"
                               style="background-color: #393E41; color: #F6F7EB !important;">Сменить пароль</v-btn>
                        <v-spacer/>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: 'ResetPassword',
        props : {
            token: String
        },
        data() {
            return {
                email: '',
                password: '',
                password_confirmation: '',
                message: '',
                status: 'success',
                show: false
            }
        },
        methods: {
            resetPasswordSubmit() {
                console.log(document.head.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            }
        },
        computed: {
            csrf_token() {
                return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
            }
        }
    }
</script>
