<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" sm="10" md="9" lg="8" xl="6">
            <v-row class="pa-4 ma-0">
                <p class="display-1 no-route-link--color">Пользователи</p>
            </v-row>
            <v-divider class="my-1"></v-divider>
            <v-col cols="12" v-for="user in users.data" :key="user.id" class="my-0 py-0">
                <v-row>
                    <v-col cols="12">
                        <v-btn icon large class="route__style" :to="{ name: 'user', params: { id: user.id } }" exact>
                            <v-avatar class="xs-image-content" size="3rem" item>
                                <v-img :src="user.image" alt="#UI">
                                </v-img>
                            </v-avatar>
                        </v-btn>
                        <span class="title xs-username-content ml-1 res__content">
                            <router-link :to="{ name: 'user', params: { id: user.id }}"
                                         class="route__style route-link--color"
                            >
                                @{{ user.username }}
                            </router-link>
                        </span>
                        <div class="inline-block__container xs-name-content">
                            <span class="title ml-2 mr-2 black--color res__content">{{ user.name }}</span>
                        </div>
                        <v-btn text icon disabled class="ml-3 mr-0 res__content">
                            <span>
                                {{ user.sum_votes > 0 ? "+" : ""}}{{ user.sum_votes }}
                            </span>
                            <v-icon class="responsive--text">mdi-diamond-stone</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>
            <div class="pa-0 ma-0">
                <div class="pa-0 ma-0">
                    <pagination
                        :limit="1"
                        size="large"
                        align="center"
                        :data="users"
                        @pagination-change-page="getResults"
                    ></pagination>
                </div>
            </div>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                users: {}
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/v1/users?page=' + page)
                    .then(({data}) => {
                        this.users = data.users;
                    });
            },
        },
        mounted() {
            axios.get('/api/v1/users')
                .then(({data}) => {
                    this.users = data.users;
                });
            this.getResults();
        },
    }
</script>

<style scoped>
    .inline-block__container {
        display: inline-block;
    }
    .res__content {
        font-size: 1rem;
    }
    @media screen and (max-width: 599px) {
        .xs-name-content {
            display: none;
        }
    }

    @media screen and (max-width: 399px) {
        .xs-image-content {
            height: 2rem !important;
            min-width: 2rem !important;
            width: 2rem !important;
        }
        .xs-username-content {
            font-size: 1rem !important;
        }
        .res__content {
            font-size: 1rem;
        }
    }

    @media screen and (min-width: 400px) and (max-width: 599px) {
        .xs-name-content {
            display: none;
        }
        .xs-image-content {
            height: 2.5rem !important;
            min-width: 2.5rem !important;
            width: 2.5rem !important;
        }
        .xs-username-content {
            font-size: 1.4rem !important;
        }
        .res__content {
            font-size: 1.4rem;
        }
    }
    /* --- */

    @media screen and (min-width: 600px) and (max-width: 959px) {
        .xs-image-content {
            height: 2.4rem !important;
            min-width: 2.4rem !important;
            width: 2.4rem !important;
        }
        .xs-username-content {
            font-size: 1rem !important;
        }
        .res__content {
            font-size: 1rem;
        }
    }
    /* --- */

    @media screen and (min-width: 960px) and (max-width: 1263px) {

    }
    /* --- */

    @media screen and (min-width: 1264px) {
        .res__content {
            font-size: 1.3rem;
        }
    }
    /* --- */

</style>
