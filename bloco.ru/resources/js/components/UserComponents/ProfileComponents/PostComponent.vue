<template>
    <div>
        <div class="album py-0">
            <div class="container row ma-0 pa-0">
                <div class="col-md-12 col-sm-12 ma-0 row pa-0 col-12">
                    <div
                        class="col-md-12 col-12 pa-0"
                        v-for="post in posts.data" :key="post.id"
                    >
                        <div class="card mb-3 box-shadow">
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
                                                    <span>
                                                            {{ post.sum_votes > 0 ? "+" : "" }}{{ post.sum_votes == null ? 0 : post.sum_votes }}
                                                        </span>
                                                </v-btn>
                                                <v-btn icon text disabled class="ml-4 mr-3">
                                                    <v-icon class="responsive--text">mdi-message-text</v-icon>
                                                    <span>{{ post.count_comments }}</span>
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
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                posts: {},
                id: this.$route.name.substring(0, 2) === 'me' ? this.$store.getters.ID : this.$route.params.id
            }
        },
        methods: {
            getResults(page = 1) {
                let url = '/api/v1/users/' + this.id + '/posts?page=' + page;
                axios.get(url)
                    .then(({data}) => {
                        this.posts = data.posts;
                    });
            },
        },
        mounted() {
            let url = '/api/v1/users/' + this.id + '/posts';
            axios.get(url)
                .then(({data}) => {
                    this.posts = data.posts;
                });
            this.getResults();
        },
        computed: {

        }
    }
</script>

<style scoped>
    .card-image-container {
        height: auto !important;
    }

    * {
        text-decoration: none !important;
    }

    @media screen and (max-width: 400px) {
        .card-image-container {
            max-height: 11rem !important;
        }
    }

    @media screen and (min-width: 401px) and (max-width: 600px) {
        .card-image-container {
            max-height: 15rem !important;
        }
    }

    @media screen and (max-width: 599px) {
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

    @media screen and (min-width: 600px) and (max-width: 960px) {
        .card-text {
            font-size: 1rem !important;
        }
        .cat-chip {
            font-size: 0.8rem !important;
        }
        .text-muted {
            font-size: 0.8rem !important;
        }
        .card-image-container {
            max-height: 17rem !important;
        }
    }

    @media screen and (min-width: 961px) and (max-width: 1264px) {
        .card-image-container {
            max-height: 20rem !important;
        }
    }

    @media screen and (min-width: 1265px) {
        .card-image-container {
            max-height: 26rem !important;
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
