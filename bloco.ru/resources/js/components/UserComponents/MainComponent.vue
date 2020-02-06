<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10">
            <v-row class="pa-2 ma-0">
                <p class="display-1 no-route-link--color">Пользователи</p>
            </v-row>
            <v-divider></v-divider>
            <v-col cols="12" v-for="user in users.data" :key="user.id" class="my-0 py-0">
                <v-row>
                    <v-col cols="8">
                        <v-btn icon large class="route__style" :to="{ name: 'user', params: { id: user.id } }" exact>
                            <v-avatar size="3rem" item>
                                <v-img :src="user.image" alt="#UI">
                                </v-img>
                            </v-avatar>
                        </v-btn>
                        <span class="title ml-2 black--color">{{ user.name }}</span>
                        <span class="title ml-1">
                            <router-link :to="{ name: 'user', params: { id: user.id }}"
                                         class="route__style route-link--color"
                            >
                                @{{ user.username }}
                            </router-link>
                        </span>
                    </v-col>
                    <v-col cols="4">
                        <v-row justify="end">
                            <p class="title mt-3 mr-2 no-route-link--color">{{ user.sum_votes > 0 ? "+" : ""}}{{ user.sum_votes }}</p>
                            <v-icon>mdi-diamond-stone</v-icon>
                        </v-row>
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

</style>
