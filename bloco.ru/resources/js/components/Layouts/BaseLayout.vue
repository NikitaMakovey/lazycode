<template>
    <div>
        <nav class="lazycode-navbar navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link class="vue-link" :to="{ path: '/' }">
                    <a class="navbar-brand logo-link">Lazycode</a>
                </router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="###">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto"></ul>
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item" v-if="!isAuth">
                            <button type="submit" class="btn logo-button">
                                <router-link :to="{ name: 'auth.login' }" class="nav-link logo-link">{{ this.menuItems.login }}</router-link>
                            </button>
                        </li>
                        <li class="nav-item" v-if="!isAuth">
                            <button type="submit" class="btn logo-button">
                                <router-link :to="{ name: 'auth.register' }" class="nav-link logo-link">{{ this.menuItems.register }}</router-link>
                            </button>
                        </li>

                        <li class="nav-item" v-if="isAuth">
                            <button type="submit" class="btn logo-button">
                                <router-link to="/posts/create" class="nav-link logo-link">{{ this.menuItems.createPost }}</router-link>
                            </button>
                        </li>
                        <li class="nav-item dropdown" v-if="isAuth">
                            <button type="submit" class="btn logo-button">
                                <a id="navbarDropdown" class="logo-link nav-link dropdown-toggle"
                                   role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ username }}
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <router-link :to="{ name: 'user', params: { id: user_id } }" class="dropdown-item vue-link">
                                        {{ this.menuItems.profile }}
                                    </router-link>
                                    <router-link :to="{ name: 'users.edit', params: { id: user_id } }" class="dropdown-item vue-link">
                                        {{ this.menuItems.setting }}
                                    </router-link>
                                    <a @click.prevent="logout" class="dropdown-item vue-link">
                                        {{ this.menuItems.logout }}
                                    </a>
                                    <hr>
                                    <router-link to="/users" class="dropdown-item">
                                        {{ this.menuItems.allUser }}
                                    </router-link>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
        <footer></footer>
    </div>
</template>

<script>
    export default {
        name: 'HomeLayout',
        data() {
            return {
                menuItems: {
                    profile: 'Профиль',
                    setting: 'Настройки',
                    logout: 'Выйти',
                    login: 'Войти',
                    register: 'Зарегистрироваться',
                    allUser: 'Все пользователи',
                    createPost: 'Запостить',
                }
            }
        },
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
