<template>
    <v-row class="xs-container">
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="11" lg="9" xl="6" class="xs-content-container">
            <v-row class="xs-container">
                <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                    class="cat-menu"
                >
                    <template v-slot:activator="{ on }">
                        <v-btn
                            text
                            dark
                            v-on="on"
                            color="#50575B"
                            class="responsive--text cat-text cat-active-text"
                        >
                            {{ ACTIVE_MODE }}
                        </v-btn>
                    </template>

                    <v-list>
                        <v-list-item
                            to="/"
                            class="route__style cat-text"
                        >
                            <v-list-item-title class="responsive--text cat-text">Все статьи</v-list-item-title>
                        </v-list-item>
                        <v-list-item
                            v-for="item in CATEGORIES"
                            :key="item.slug"
                            :to="{ name: 'category', params: { slug: item.slug } }"
                            class="route__style cat-text"
                            exact
                        >
                            <v-list-item-title class="responsive--text cat-text">{{ item.name }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-row>
            <v-divider class="ma-xs-0"></v-divider>
            <div class="album py-0">
                <div class="container row ma-0">
                    <div class="col-md-8 ma-0 row pa-0">
                        <div
                            class="col-md-12 col-12 "
                            v-for="post in posts.data" :key="post.id"
                        >
                            <div class="card mb-2 box-shadow">
                                <div class="card-image-container">
                                    <router-link
                                        :to="{ name: 'post', params: { id: post.id } }" exact
                                        class="route__style"
                                    >
                                        <img class="card-img-top" :src="post.image"
                                             alt="Card image cap"
                                        >
                                    </router-link>
                                </div>
                                <div class="card-body">
                                    <router-link
                                        :to="{ name: 'post', params: { id: post.id } }" exact
                                        class="route__style mb-4"
                                    >
                                        <p class="card-text">
                                            {{ post.title }}
                                        </p>
                                    </router-link>
                                    <p class="card-text topic-color">
                                        <v-chip
                                            class="mx-0 mt-2 route__style cat-chip"
                                            color="#8EC5FC"
                                            :to="{ name: 'category', params: { slug: post.slug } }"
                                        >
                                            {{ post.name }}
                                        </v-chip>
                                    </p>
                                    <v-col cols="12" class="pt-0">
                                        <v-row>
                                            <v-card class="px-2 py-0" outlined>
                                                <v-card-actions>
                                                    <v-btn text icon disabled class="ml-3 mr-4">
                                                        <v-icon class="responsive--text">mdi-star-four-points</v-icon>
                                                        <span>+53</span>
                                                    </v-btn>
                                                    <v-btn icon text disabled class="ml-4 mr-3">
                                                        <v-icon class="responsive--text">mdi-message-text</v-icon>
                                                        <span>12</span>
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-row>
                                    </v-col>
                                    <div class="my-1">
                                        <small class="text-muted">{{ $moment(post.created_at).format("LL") }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ma-0 pa-0 xs-cat-top-container">

                        <div class="card mt-3 box-shadow">
                            <div class="card-body pa-0">
                                <v-list subheader>
                                    <v-subheader class="cat-header-text">
                                        ПОПУЛЯРНЫЕ КАТЕГОРИИ
                                    </v-subheader>

                                    <v-list-item
                                        v-for="item in CATEGORIES"
                                        :key="item.id"
                                        :to="{ name: 'category', params: { slug: item.slug } }"
                                        v-if="item.cat_count > 1"
                                    >
                                        <v-list-item-content>
                                            <v-list-item-title
                                                class="cat-item-text"
                                                v-text="item.name"
                                            ></v-list-item-title>
                                        </v-list-item-content>

                                        <v-list-item-icon class="cat-icon-text">
                                            {{ item.cat_count }}
                                        </v-list-item-icon>
                                    </v-list-item>
                                </v-list>
                            </div>
                        </div>

                    </div>
                    <v-divider></v-divider>
                    <div class="pa-0 ma-0">
                        <div class="pa-0 ma-0">
                            <pagination
                                :limit="1"
                                size="large"
                                align="center"
                                :data="posts"
                                @pagination-change-page="getResults"
                            ></pagination>
                        </div>
                    </div>
                </div>
            </div>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                activeMode: "Все посты",
                posts: {}
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('/api/v1/posts?page=' + page)
                    .then(({data}) => {
                        this.posts = data.posts;
                    });
            },
        },
        mounted() {
            axios.get('/api/v1/posts')
                .then(({data}) => {
                    this.posts = data.posts;
                });
            this.getResults();
            this.$store.dispatch('GET_CATEGORIES');
        },
        computed: {
            ...mapGetters(['CATEGORIES']),
            /**
             * @return {string}
             */
            ACTIVE_MODE() { return this.activeMode }
        }
    }
</script>

<style scoped>
    .cat-text {
        text-transform: uppercase;
    }
    .cat-item-text {
        text-transform: uppercase;
        word-wrap: break-word;
        overflow: inherit !important;
        text-overflow: inherit !important;
        white-space: inherit !important;
    }

    * {
        text-decoration: none !important;
    }

    @media screen and (max-width: 400px) {
        .card-image-container {
            max-height: 9rem !important;
        }
    }

    @media screen and (min-width: 401px) and (max-width: 600px) {
        .card-image-container {
            max-height: 11rem !important;
        }
    }

    @media screen and (max-width: 600px) {
        .xs-cat-top-container {
            display: none;
        }
        .xs-content-container {
            padding: 0;
        }
        .xs-container {
            margin: 0;
            padding: 0;
        }
        .ma-xs-0 {
            margin: 0 !important;
        }
        .cat-text {
            font-size: 0.8rem !important;
        }
        .cat-active-text {
            margin: 0.4rem !important;
            overflow: inherit !important;
            word-wrap: break-word;
            white-space: inherit !important;
        }
        .card-text {
            font-size: 1rem !important;
        }
        .cat-chip {
            font-size: 0.8rem !important;
        }
        .text-muted {
            font-size: 0.8rem !important;
        }
    }

    @media screen and (min-width: 601px) and (max-width: 960px) {
        .xs-container {
            margin: 0 !important;
        }
        .container {
            padding: 0 !important;
        }
        .card-image-container {
            max-height: 13rem !important;
        }
        .cat-header-text {
            font-size: 0.9rem;
            font-weight: bold;
            color: #8EC5FC;
        }
        .cat-item-text {
            font-size: 0.7rem;
            word-wrap: break-word;
            overflow: inherit !important;
            text-overflow: inherit !important;
            white-space: inherit !important;
        }
        .cat-icon-text {
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem !important;
        }
        .cat-active-text {
            margin: 0.4rem !important;
        }
        .cat-text {
            font-size: 1rem !important;
        }
        .cat-chip {
            font-size: 0.8rem !important;
        }
        .text-muted {
            font-size: 0.8rem !important;
        }
    }

    @media screen and (min-width: 961px) and (max-width: 1264px) {
        .card-image-container {
            max-height: 15rem !important;
        }
        .xs-container {
            margin: 0 !important;
        }
        .container {
            padding: 0 !important;
        }
        .cat-header-text {
            font-size: 1.2rem;
            font-weight: bold;
            color: #8EC5FC;
        }
        .cat-item-text {
            font-size: 1rem;
        }
        .cat-icon-text {
            font-weight: bold;
        }
        .cat-active-text {
            margin: 0.4rem !important;
        }
        .cat-text {
            font-size: 1rem !important;
        }
    }

    @media screen and (min-width: 1265px) {
        .cat-header-text {
            font-size: 1.2rem;
            font-weight: bold;
            color: #8EC5FC;
        }
        .cat-item-text {
            font-size: 1rem;
        }
        .cat-icon-text {
            font-weight: bold;
        }
        .cat-active-text {
            margin: 0.4rem !important;
        }
        .cat-text {
            font-size: 1rem !important;
        }

    }

    .card-image-container {
        overflow: hidden;
        width: 100%;
        height: 18rem;
        justify-content: center;
        align-items: center;
        border-bottom: 1px solid #E0C3FC;
        background-color: #8EC5FC;
        background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    }
    .text-muted {
        font-size: 1rem;
    }
    .card-img-top:hover {
        opacity: 75%;
    }
    .card-text {
        font-size: 1.2rem;
        color: #000 !important;
    }
    .card-text:hover {
        color: #8EC5FC !important;
    }
    .cat-chip {
        font-size: 1rem;
        color: #000 !important;
        overflow: inherit !important;
        word-wrap: break-word;
        white-space: inherit !important;
    }
    .cat-chip:hover {
        background-color: #E0C3FC !important;
    }
    img {
        height: auto;
        width: 100%;
    }
    @media (min-width : 1905px) {
        .responsive--text {
            font-size : 2rem !important;
        }
    }
</style>
