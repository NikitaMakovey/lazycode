<template>
    <v-col cols="12" class="post-bg pa-2">
        <template v-if="POST != null">
            <v-row class="pa-0 ma-0">
                <v-col cols="12" class="mb-0">
                    <v-row class="ma-0">
                        <v-btn icon small class="route__style mr-2"
                               :to="{ name: 'user.about', params: { id: POST.author_id } }" exact
                        >
                            <v-avatar size="32px" item>
                                <v-img :src="POST.user_image" alt="#UI">
                                </v-img>
                            </v-avatar>
                        </v-btn>
                        <span class="mx-1">
                            <router-link :to="{ name: 'user.about', params: { id: POST.author_id }}"
                                         class="route__style route-link--color"
                            >
                                @{{ POST.username }}
                            </router-link>
                        </span>
                    </v-row>
                </v-col>
                <v-col cols="12" class="ma-0 pt-0">
                    <span>{{ $moment(POST.created_at).format("LL") }}</span>
                </v-col>
                <v-col cols="12" class="mb-1 py-0">
                    <v-row class="py-0 ma-0">
                        <p class="title no-route-link--color mr-1 my-0">
                            {{ POST.title }}
                        </p>
                        <v-btn text icon class="route__style ml-1"
                               :to="{ name: 'posts.edit', params: { id: POST.id } }"
                               v-if="POST.author_id == $store.getters.ID"
                        >
                            <v-icon>mdi-fountain-pen-tip</v-icon>
                        </v-btn>
                    </v-row>
                </v-col>
                <v-col cols="12" class="mb-1 py-0">
                    <v-row class="py-0 ma-0">
                        <v-chip
                            class="ma-0 subtitle-1"
                            color="#50575B" dark
                            :to="{ name: 'category', params: { slug: POST.slug } }"
                        >
                            {{ POST.name }}
                        </v-chip>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-img :src="POST.image" style="height: auto; max-width: 100%"></v-img>
                </v-col>
                <v-col cols="12">
                    <v-row v-html="POST.body" class="post-body--html mx-0"></v-row>
                </v-col>
                <v-col cols="12">
                    <div>
                        <v-chip
                            class="mx-0 mt-2 route__style cat-chip"
                            color="#89BD9E"
                            size="large"
                            @click="confirm"
                        >
                            Одобрить
                        </v-chip>
                        <v-chip
                            class="mx-0 mt-2 route__style cat-chip"
                            color="#DB4C40"
                            size="large"
                            @click="destroy"
                        >
                            Отказать
                        </v-chip>
                    </div>
                </v-col>
            </v-row>
        </template>
        <template v-else>
            <v-row class="pa-0 ma-0">
                <v-col cols="12" class="mb-0">
                    <div class="text-center">
                        <v-progress-circular
                            :size="70"
                            :width="7"
                            color="#393E41"
                            indeterminate
                        ></v-progress-circular>
                    </div>
                </v-col>
            </v-row>
        </template>
    </v-col>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                post_: null
            }
        },
        mounted() {
            let url = '/api/v1/admin/edits/' + this.$route.params.id;
            let token = this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            axios.get(url, config).then(({data}) => {
                this.post_ = data.post;
            })
        },
        methods: {
            confirm() {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/admin/edit-posts/' + this.$route.params.id;
                axios.get(url, config).then(() => {
                    this.$router.back();
                });
            },
            destroy() {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let url = '/api/v1/admin/edit-posts/' + this.$route.params.id;
                axios.delete(url, config).then(() => {
                    this.$router.back();
                });
            }
        },
        computed: {
            POST() { return this.post_ }
        }
    }
</script>

<style scoped>
    .post-bg {
        background-image: linear-gradient( 109.6deg,  rgba(204,228,247,1) 11.2%, rgba(237,246,250,1) 100.2% );
    }
</style>
