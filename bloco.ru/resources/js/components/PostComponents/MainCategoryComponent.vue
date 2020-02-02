<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" sm="9" md="9" lg="9" xl="10">
            <v-row>
                <v-menu
                    bottom
                    origin="center center"
                    transition="scale-transition"
                >
                    <template v-slot:activator="{ on }">
                        <v-btn
                            text
                            dark
                            v-on="on"
                            color="#50575B"
                            class="responsive--text"
                        >
                            {{ ACTIVE_MODE }}
                        </v-btn>
                    </template>

                    <v-list>
                        <v-list-item
                            to="/"
                            class="route__style"
                        >
                            <v-list-item-title class="responsive--text">Все статьи</v-list-item-title>
                        </v-list-item>
                        <v-list-item
                            v-for="item in CATEGORIES"
                            :key="item.slug"
                            :to="{ name: 'category', params: { slug: item.slug } }"
                            class="route__style"
                            @click="setCategory(item.name)"
                            exact
                        >
                            <v-list-item-title class="responsive--text">{{ item.name }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-row>
            <v-divider></v-divider>
            <div class="album py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6" v-for="post in posts" :key="post.id">
                            <div class="card mb-6 box-shadow">
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
                                            class="mx-0 mt-2 route__style"
                                            color="#8EC5FC"
                                            :to="{ name: 'category', params: { slug: post.slug } }"
                                        >
                                            {{ post.name }}
                                        </v-chip>
                                    </p>
                                    <v-col cols="12">
                                        <v-row>
                                            <v-card class="px-2 py-0" outlined>
                                                <v-card-actions>
                                                    <v-btn text icon>
                                                        <v-icon class="responsive--text">mdi-star-four-points</v-icon>
                                                    </v-btn>
                                                    <p class="subtitle-2 mt-3 ml-1 mr-1 responsive--text">+53</p>
                                                    <v-btn icon>
                                                        <v-icon class="responsive--text">mdi-message-text</v-icon>
                                                    </v-btn>
                                                    <p class="subtitle-2 mt-3 ml-1 mr-1 responsive--text">12</p>
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
                    <v-divider></v-divider>
                    <div class="pa-0 ma-0">
                        <div class="pa-0 ma-0">
                            <pagination
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
                activeMode: '',
                posts: {}
            }
        },
        methods: {
            setCategory(name) {
                this.activeMode = name;
                axios.get('/api/v1/categories/' + this.$route.params.slug)
                    .then(({data}) => {
                        this.posts = data.posts;
                    });
            },
            getResults(page = 1) {
                axios.get('/api/v1/categories/' + this.$route.params.slug + '?page=' + page)
                    .then(({data}) => {
                        this.posts = data.posts;
                    });
            },
        },
        mounted() {
            console.log(this.$route.params.slug);
            axios.get('/api/v1/categories/' + this.$route.params.slug)
                .then(({data}) => {
                    this.posts = data.posts;
                });
            this.getResults();
            this.$store.dispatch('GET_CATEGORIES')
                .then((data) => {
                    this.activeMode = (data).find(x => x.slug === this.$route.params.slug).name;
                })
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
    .card-image-container {
        overflow: hidden;
        width: 100%;
        height: 15rem;
        justify-content: center;
        align-items: center;
        border-bottom: 1px solid #E0C3FC;
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
