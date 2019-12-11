<template>
    <v-app id="inspire">
        <v-app-bar app clipped-left color="brown lighten-2">
            <router-link class="vue-link" :to="{ path: '/' }">
                <span class="title ml-3 mr-5">Lazy&nbsp;<span class="font-weight-light">code</span></span>
            </router-link>
            <v-text-field solo-inverted flat hide-details label="Поиск"></v-text-field>
            <v-spacer></v-spacer>

            <v-btn :to="{ name: 'users' }" flat color="brown lighten-2">
                <i class="fas fa-users"></i>
                <span>Все пользователи</span>
            </v-btn>
            <v-btn :to="{ name: 'posts.create' }" flat color="brown lighten-2">
                <i class="fas fa-pen"></i>
                <span>Запостить</span>
            </v-btn>
            <v-menu>
                <v-btn flat slot="activator" color="brown lighten-2">
                    <span>{{ username }}</span>
                </v-btn>
                <v-list>
                    <v-list-item>
                        <v-list-item-title router :to="{ name: 'user', params: { id: user_id }}">
                            Профиль
                        </v-list-item-title>
                        <v-list-item-title router :to="{ name: 'users.edit', params: { id: user_id }}">
                            Настройки
                        </v-list-item-title>
                        <v-list-item-title @click.prevent="logout">
                            Выйти
                        </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-content>
            <v-container fluid fill-height class="grey lighten-4">
                <v-layout justify-center align-center>
                    <router-view></router-view>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: 'SkeletonComponent',
        methods: {
            logout() {
                this.$store.dispatch('SIGN_OUT').then(() => { this.$router.push({ name: 'main' }) });
            }
        },
        computed: {
            username() { return this.$store.getters.USERNAME },
            user_id() { return this.$store.getters.USER_ID },
            isAuth() { return this.$store.getters.AUTH_TOKEN },
            csrf_token() { return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        },
        mounted() {
            console.log(this.$store.getters.AUTH_TOKEN);
            console.log(this.$store.getters.USERNAME);
            console.log(this.$store.getters.USER_ID);
        }
    }
</script>

<style scoped>

</style>
