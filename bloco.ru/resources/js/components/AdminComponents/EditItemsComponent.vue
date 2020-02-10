<template>
    <div class="album py-0">
        <div class="container row ma-0 pa-0">
            <div class="col-md-12 col-sm-12 ma-0 row pa-0 col-12">
                <div
                    class="col-md-6 col-sm-12 col-lg-6 col-xl-6 col-12 pa-0"
                    v-for="post in posts.data" :key="post.id"
                >
                    <div class="card mb-2 mx-1 pa-1 box-shadow">
                        <div class="card-image-container">
                            <router-link
                                :to="{ name: 'admin.edit', params: { id: post.id } }" exact
                                class="route__style"
                            >
                                <img class="card-img-top" :src="post.image"
                                     alt="Card image cap"
                                >
                            </router-link>
                        </div>
                        <div class="card-body">
                            <router-link
                                :to="{ name: 'admin.edit', params: { id: post.id } }" exact
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
                            <div class="my-1">
                                <small class="text-muted">{{ $moment(post.created_at).format("LL") }}</small>
                            </div>
                            <div class="my-1">
                                <v-chip
                                    class="mx-0 mt-2 route__style cat-chip"
                                    color="#89BD9E"
                                    @click="confirm(post.id)"
                                >
                                    Одобрить
                                </v-chip>
                                <v-chip
                                    class="mx-0 mt-2 route__style cat-chip"
                                    color="#DB4C40"
                                    @click="destroy(post.id)"
                                >
                                    Отказать
                                </v-chip>
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
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                posts: {},
                message: ''
            }
        },
        methods : {
            getResults(page = 1) {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/admin/edit-posts?page=' + page;
                axios.get(url, config)
                    .then(({data}) => {
                        this.posts = data.posts;
                    });
            },
            confirm(id) {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/admin/edit-posts/' + id;
                axios.get(url, config).then(() => {
                    this.posts.data = this.posts.data.filter(x => x.id !== id);
                });
            },
            destroy(id) {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/admin/edit-posts/' + id;
                axios.delete(url, config).then(() => {
                    this.posts.data = this.posts.data.filter(x => x.id !== id);
                });
            }
        },
        mounted() {
            let token = this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            let url = '/api/v1/admin/edit-posts';
            axios.get(url, config).then(({data}) => {
                this.posts = data.posts;
            })
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
        .container {
            padding: 0 !important;
        }
        .card-image-container {
            height: auto !important;
            max-height: 20rem !important;
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

    @media screen and (min-width: 961px) and (max-width: 1264px) {
        .card-image-container {
            max-height: 20rem !important;
        }
        .container {
            padding: 0 !important;
        }
    }

    @media screen and (min-width: 1265px) {
        .card-image-container {
            max-height: 20rem !important;
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
</style>
