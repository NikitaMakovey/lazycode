<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app temporary>
            <v-list dense>
                <template>
                    <v-list-item
                        :to="{ name: 'main' }"
                        class="route__style"
                        exact
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon left small>mdi-script</v-icon>
                                <span>{{ items[3].text }}</span>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        :to="{ name: 'users' }"
                        class="route__style"
                        exact
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon left small>mdi-script</v-icon>
                                <span>{{ items[4].text }}</span>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
                <template v-if="isAuth">
                    <v-list-item
                        :to="{ name: 'user', params: { id: userId } }"
                        class="route__style"
                        exact
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon left small>mdi-script</v-icon>
                                <span>{{ items[0].text }}</span>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        :to="{ name: 'users.edit', params: { id: userId } }"
                        class="route__style"
                        exact
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon left small>mdi-script</v-icon>
                                <span>{{ items[1].text }}</span>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        :to="{ name: 'posts.create' }"
                        class="route__style"
                        exact
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon left small>mdi-script</v-icon>
                                <span>{{ items[2].text }}</span>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item
                        :to="{ name: 'posts.create' }"
                        class="route__style"
                        exact
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon left small>mdi-script</v-icon>
                                <span>{{ items[5].text }}</span>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </template>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar app color="#393E41" dark>
            <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
                <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                <span class="hidden-sm-and-down">Lazy<span class="font-weight-light">code</span></span>
            </v-toolbar-title>
            <v-text-field
                flat
                solo-inverted
                hide-details
                prepend-inner-icon="mdi-file-document-box-search-outline"
                label="Поиск"
                class="hidden-sm-and-down">
            </v-text-field>
            <v-spacer></v-spacer>
            <template v-if="isAuth">
                <v-btn text color="#50575B #F6F7EB--text"
                       class="route__style" :to="{ name: 'user', params: { id: userId } }" exact
                >
                    {{ username }}
                </v-btn>
                <v-btn icon large class="route__style" :to="{ name: 'user', params: { id: userId } }" exact>
                    <v-avatar size="32px" item>
                        <v-img :src="userImage" alt="#UI">
                        </v-img>
                    </v-avatar>
                </v-btn>
            </template>
            <template v-else>
                <v-btn text color="#50575B #F6F7EB--text" class="route__style" :to="{ name: 'auth.login' }">Войти</v-btn>
                <v-btn text color="#50575B #F6F7EB--text" class="route__style" :to="{ name: 'auth.register' }">Зарегистрироваться</v-btn>
            </template>
        </v-app-bar>
        <v-content>
            <v-container fluid fill-height>
                <v-layout>
                    <router-view></router-view>
                </v-layout>
            </v-container>
        </v-content>
        <footer-component></footer-component>
    </v-app>
</template>

<script>
    import FooterComponent from "./FooterComponent";

    export default {
        components: {
            FooterComponent
        },
        data () {
            return {
                activeClass: 'route--active',
                drawer: null,
                items: [
                    { icon: 'fas fa-user', text: 'Профиль',
                        route: "{ name: 'user', params: { id: USER_ID } }" },
                    { icon: 'fas fa-user-cog', text: 'Настройки профиля',
                        route: "{ name: 'users.edit', params: { id: USER_ID } }" },
                    { icon: 'fas fa-pencil-alt', text: 'Запостить',
                        route: "{ name: 'posts.create' }" },
                    { icon: 'fas fa-book-open', text: 'Все посты',
                        route: "{ name: 'posts' }" },
                    { icon: 'fas fa-users', text: 'Все пользователи',
                        route: "{ name: 'users' }" },
                    { icon: '-', text: 'Выход', route: "-"}
                ]
            }
        },
        methods: {
            logout() {
                this.$store.dispatch('SIGN_OUT').then(() => { this.$router.push({ name: 'main' }) });
            }
        },
        computed: {
            userImage() { return this.$store.getters.IMAGE },
            username() { return this.$store.getters.USERNAME },
            userId() { return this.$store.getters.USER_ID },
            isAuth() { return this.$store.getters.AUTH_TOKEN },
            csrfToken() { return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content') }
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
