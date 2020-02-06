<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 94vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 94vh">
                <v-col cols="12">
                    <v-row class="pa-1">
                        <p class="display-1">Склад статей</p>
                    </v-row>
                    <v-col cols="12" class="ma-0 pa-0"
                    >
                        <v-row class="ma-0 pa-0">
                            <div
                                class="col-md-6 col-6 pa-1"
                                v-for="post in posts" :key="post.id"
                            >
                                <div class="card mb-2 box-shadow">
                                    <div class="card-image-container">
                                        <router-link
                                            :to="{ name: 'admin.post', params: { id: post.id } }" exact
                                            class="route__style"
                                        >
                                            <img class="card-img-top" :src="post.image"
                                                 alt="Card image cap"
                                            >
                                        </router-link>
                                    </div>
                                    <div class="card-body">
                                        <router-link
                                            :to="{ name: 'admin.post', params: { id: post.id } }" exact
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
                                            <template v-if="post.post_verified_is == true">
                                                <v-chip
                                                    class="mx-0 mt-2 route__style cat-chip"
                                                    color="#1ACA4C"
                                                    @click="reject(post.id)"
                                                >
                                                    Заблокировать
                                                </v-chip>
                                            </template>
                                            <template v-else-if="post.post_verified_is == false">
                                                <v-chip
                                                    class="mx-0 mt-2 route__style cat-chip"
                                                    color="#8E41F5"
                                                    @click="confirm(post.id)"
                                                >
                                                    Разблокировать
                                                </v-chip>
                                            </template>
                                            <template v-else>
                                                <v-chip
                                                    class="mx-0 mt-2 route__style cat-chip"
                                                    color="#8E41F5"
                                                    @click="confirm(post.id)"
                                                >
                                                    Одобрить
                                                </v-chip>
                                                <v-chip
                                                    class="mx-0 mt-2 route__style cat-chip"
                                                    color="#1ACA4C"
                                                    @click="reject(post.id)"
                                                >
                                                    Отказать
                                                </v-chip>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </v-row>
                    </v-col>
                </v-col>
            </div>
        </v-container>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                posts: []
            }
        },
        methods : {
            confirm(id) {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/confirm/' + id;
                axios.get(url, config).then(() => {
                    for (let i = 0; i < this.posts.length; i++) {
                        if (this.posts[i].id == id) {
                            this.posts[i].post_verified_is = true;
                            break;
                        }
                    }
                });
            },
            reject(id) {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/reject/' + id;
                axios.get(url, config).then(() => {
                    for (let i = 0; i < this.posts.length; i++) {
                        if (this.posts[i].id == id) {
                            this.posts[i].post_verified_is = false;
                            break;
                        }
                    }
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
            let url = '/api/v1/admin/posts';
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
        .card-image-container {
            max-height: 18rem !important;
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
