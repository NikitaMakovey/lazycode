<template>
    <div>
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <v-row class="ma-0 pa-0">
                    <v-spacer></v-spacer>
                    <v-col cols="10">
                        <div class="container container-block">
                            <div class="row">
                                <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 py-4 legend-block">
                                    <p class="text-white title">О нас</p>
                                    <p class="text-muted title">
                                        {{ legend_text }}
                                    </p>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 py-4 ma-0 list-container">
                                    <ul class="list-unstyled">
                                        <li>
                                            <router-link to="/" class="text-white">
                                                <span class="list-element-text">Все посты</span>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link to="/users" class="text-white">
                                                <span class="list-element-text">Все пользователи</span>
                                            </router-link>
                                        </li>
                                        <li>
                                            <router-link to="/labs/graph" class="text-white">
                                                <span class="list-element-text">Лаборатория</span>
                                            </router-link>
                                        </li>
                                        <template v-if="ACCESS_TOKEN">
                                            <li>
                                                <router-link :to="{ name: 'user.about', params: { id: ID } }" class="text-white">
                                                    <span class="list-element-text">Мой профиль</span>
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link to="/home/publish" class="text-white">
                                                    <span class="list-element-text">Мой дом</span>
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link to="/settings/main" class="text-white">
                                                    <span class="list-element-text">Мой гараж</span>
                                                </router-link>
                                            </li>
                                            <li>
                                                <router-link to="/post/create" class="text-white">
                                                    <span class="list-element-text">Написать статью</span>
                                                </router-link>
                                            </li>
                                            <template v-if="IS_ADMIN ==='true'">
                                                <li>
                                                    <router-link :to="{ name: 'admin' }" class="text-white">
                                                        <span class="list-element-text">Каморка админа</span>
                                                    </router-link>
                                                </li>
                                            </template>
                                            <li @click="logout">
                                                <span class="list-element-text text-white pa-0 ma-0">Выйти</span>
                                            </li>
                                        </template>
                                        <template v-else>
                                            <li>
                                                <router-link to="/auth/login" class="text-white">
                                                    <span class="list-element-text">Войти</span>
                                                </router-link>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </v-col>
                    <v-spacer></v-spacer>
                </v-row>
            </div>
            <div class="navbar navbar-dark bg-dark box-shadow navbar-container">
                <div class="container d-flex justify-content-between pa-sm-2 pa-md-2 pa-lg-2 pa-xl-2">
                    <router-link :to="{ name: 'main' }" class="navbar-brand d-flex align-items-center">
                        <strong>Lazycode</strong>
                    </router-link>
                    <button
                        class="navbar-toggler" type="button"
                        data-toggle="collapse" data-target="#navbarHeader"
                        aria-controls="navbarHeader" aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </header>

        <main role="main">
            <router-view></router-view>
        </main>

        <footer class="text-muted bg-dark">
            <div class="container">
                <p class="title basic-footer">{{ new Date().getFullYear() }} &copy; Lazycode</p>
            </div>
        </footer>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                legend_text : "Lazycode - не просто платформа для создания " +
                    "статей и их просмотра - это социальная сеть для тех, кому интересны естественные " +
                    "науки, IT, путешествия и многие другие темы. Присоединяйся к нам - стань частью " +
                    "дружной и интеллектуальной команды."
            }
        },
        methods: {
            logout() {
                this.$store.dispatch('LOGOUT_USER')
                    .then(() => { this.$router.push({ name: 'main' }) });
            }
        },
        computed: {
            IS_ADMIN() { return this.$store.getters.IS_ADMIN },
            ID() { return this.$store.getters.ID },
            ACCESS_TOKEN() { return this.$store.getters.ACCESS_TOKEN },
            csrfToken() { return document.head.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        },
        mounted() {

        }
    }
</script>

<style scoped>
    @media screen and (max-width: 600px) {
        .legend-block {
            display: none;
        }
        .text-muted {
            font-size: 1rem !important;
        }
        .list-container {
            padding: 0 !important;
        }
        .list-unstyled {
            padding-left: 30px;
            margin-bottom: 0;
        }
        .list-element-text {
            font-size: 1rem !important;
            font-weight: bold;
        }
        .container-block {
            border-bottom: 1px solid #8EC5FC;
        }
    }
    @media screen and (min-width: 601px) and (max-width: 960px) {
        .text-muted {
            font-size: 1rem !important;
        }
        .list-unstyled {
            padding-left: 18px;
            margin-bottom: 0;
        }
        .list-element-text {
            font-size: 1rem !important;
            font-weight: bold;
        }
    }
    @media screen and (min-width: 961px) and (max-width: 1264px) {
        .text-muted {
            font-size: 1rem !important;
        }
        .list-unstyled {
            padding-left: 18px;
            margin-bottom: 0;
        }
        .list-element-text {
            font-size: 1rem !important;
            font-weight: bold;
        }
    }
    @media screen and (min-width: 1265px) {
        .text-muted {
            font-size: 1rem !important;
        }
        .list-unstyled {
            padding-left: 18px;
            margin-bottom: 0;
        }
        .list-element-text {
            font-size: 1rem !important;
            font-weight: bold;
        }
    }
    * {
        text-decoration: none !important;
    }
    .text-white:hover {
        color: #E0C3FC !important;
    }
    .basic-footer {
        font-size: 1rem !important;
    }
    main {
        min-height: 90vh;
        background-color: #8EC5FC;
        background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    }
    .basic-footer {
        color: #8EC5FC;
    }
</style>
