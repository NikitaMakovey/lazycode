<template>
    <div>
        <div class="album py-0">
            <div class="container row ma-0">
                <div class="col-md-12 col-sm-12 ma-0 row pa-0 col-12">
                    <div
                        class="col-md-12 col-12 "
                        v-for="comment in comments.data" :key="comment.id"
                    >
                        <div class="card mb-2 box-shadow">
                            <div class="card-body">
                                <router-link
                                    :to="{ name: 'post', params: { id: comment.id } }" exact
                                    class="route__style mb-4"
                                >
                                    <p class="card-text">
                                        {{ comment.title }}
                                    </p>
                                </router-link>
                                <v-col cols="12" class="pt-0">
                                    <v-row v-text="comment.body">
                                    </v-row>
                                </v-col>
                                <v-col cols="12" class="pt-0">
                                    <v-row>
                                        <v-card class="px-2 py-0" outlined>
                                            <v-card-actions>
                                                <v-btn text icon disabled class="ml-3 mr-4">
                                                    <v-icon class="responsive--text">mdi-star-four-points</v-icon>
                                                    <span>
                                                        {{ comment.sum_votes > 0 ? "+" : "" }}{{ comment.sum_votes == null ? 0 : comment.sum_votes }}
                                                    </span>
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-row>
                                </v-col>
                                <div class="my-1">
                                    <small class="text-muted">{{ $moment(comment.created_at).format("LL") }}</small>
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
                            :data="comments"
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
                comments: {},
                id: this.$route.name.substring(0, 2) === 'me' ? this.$store.getters.ID : this.$route.params.id
            }
        },
        methods: {
            getResults(page = 1) {
                let url = '/api/v1/users/' + this.id + '/comments?page=' + page;
                axios.get(url)
                    .then(({data}) => {
                        this.comments = data.comments;
                    });
            },
        },
        mounted() {
            let url = '/api/v1/users/' + this.id + '/comments';
            axios.get(url)
                .then(({data}) => {
                    this.comments = data.comments;
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
            max-height: 11rem !important;
        }
    }

    @media screen and (min-width: 401px) and (max-width: 600px) {
        .card-image-container {
            max-height: 15rem !important;
        }
    }

    @media screen and (max-width: 599px) {
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

    @media screen and (min-width: 600px) and (max-width: 960px) {
        .xs-container {
            margin: 0 !important;
        }
        .container {
            padding: 0 !important;
        }
        .card-image-container {
            height: auto !important;
            max-height: 15rem !important;
        }
        .cat-header-text {
            font-size: 0.9rem;
            font-weight: bold;
            color: #8EC5FC;
        }
        .cat-item-text {
            font-size: 0.8rem;
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
            max-height: 20rem !important;
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
        color: #a09aee !important;
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
