<template>
    <v-row align="center" justify="center" class="ma-0">
        <v-col cols="12" sm="8" md="6" lg="4" xl="2" class="pa-0">
            <v-card class="elevation-12">
                <v-toolbar color="#393E41" dark flat class="toolbar-container">
                    <v-toolbar-title class="header-title-auth-text">Подтверждение почты</v-toolbar-title>
                    <v-spacer/>
                </v-toolbar>
                <v-card-text>
                    <template v-if="message === ''">
                        <div class="text-center">
                            <v-progress-circular
                                :size="70"
                                :width="7"
                                color="#393E41"
                                indeterminate
                            ></v-progress-circular>
                        </div>
                    </template>
                    <template v-else>
                        <div class="text-center">
                            <span class="title">
                                Ваш E-mail подтверждён успешно!
                            </span>
                        </div>
                    </template>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                message: ''
            }
        },
        mounted() {
            setTimeout(this.access, 2000);
        },
        methods: {
            access: function () {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/email/confirm';
                let d = { code : this.$route.params.code };
                const Router = this.$router;
                axios.post(url, d, config).then(({data}) => {
                    this.message = data.message;
                    setTimeout(function () {
                        Router.push({ name: 'main' });
                    }, 2000)
                }).catch(() => {
                    Router.push({ name: 'auth.login' });
                });
            }
        }
    }
</script>

<style scoped>

</style>
