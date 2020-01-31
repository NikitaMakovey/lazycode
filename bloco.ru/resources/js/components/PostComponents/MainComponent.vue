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
                            @click="getCategory(0, 'Все посты')"
                            class="route__style"
                        >
                            <v-list-item-title class="responsive--text">Все посты</v-list-item-title>
                        </v-list-item>
                        <v-list-item
                            v-for="item in CATEGORIES"
                            :key="item.id"
                            @click="getCategory(item.id, item.name)"
                            class="route__style"
                        >
                            <v-list-item-title class="responsive--text">{{ item.name }}</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-row>
            <v-divider></v-divider>
            <v-col cols="12" v-for="post in POSTS" :key="post.post_id">
                <v-row>
                    <v-col cols="12" class="mb-0">
                        <v-row>
                            <v-btn icon small class="route__style mr-2"
                                   :to="{ name: 'user', params: { id: post.user_id } }" exact
                            >
                                <v-avatar class="responsive--image" size="32px" item>
                                    <v-img :src="post.user_image" alt="#UI">
                                    </v-img>
                                </v-avatar>
                            </v-btn>
                            <span>
                                <router-link :to="{ name: 'user', params: { id: post.user_id }}"
                                             class="route__style route-link--color responsive--text"
                                >
                                    @{{ post.username }}
                                </router-link>
                            </span>
                            <!--<span>{{ post.created_at }}</span>-->
                        </v-row>
                    </v-col>
                    <v-col cols="12" class="mb-0 py-0">
                        <v-row class="py-0 my-0">
                            <p class="title my-1">
                                <router-link class="route__style route-link--color responsive--text"
                                             :to="{ name: 'post', params: { id: post.post_id }}"
                                >
                                    {{ post.post_title }}
                                </router-link>
                            </p>
                        </v-row>
                    </v-col>
                    <v-col cols="12" class="ma-0 py-0">
                        <v-row class="my-0 py-0">
                            <v-chip
                                class="ma-0 subtitle-1 responsive--text"
                                color="#50575B" dark
                            >
                                {{ post.category }}
                            </v-chip>
                        </v-row>
                    </v-col>
                    <v-col cols="12">
                        <v-row v-html="post.post_body" class="post-body--html responsive--text"></v-row>
                    </v-col>
                    <v-col cols="12">
                        <v-row>
                            <v-btn class="route__style responsive--text"
                                   dark outlined color="#50575B"
                                   :to="{ name: 'post', params: { id: post.post_id } }" exact
                            >
                                Читать весь пост
                            </v-btn>
                        </v-row>
                    </v-col>
                    <v-col cols="12">
                        <v-row>
                            <v-card class="px-2 py-0" outlined>
                                <v-card-actions>
                                    <v-btn text icon>
                                        <v-icon class="responsive--text">mdi-star-four-points</v-icon>
                                    </v-btn>
                                    <p class="subtitle-2 mt-3 ml-1 mr-1 responsive--text">{{ post.rating > 0 ? "+" : ""}}{{ post.rating }}</p>
                                    <v-btn icon>
                                        <v-icon class="responsive--text">mdi-message-text</v-icon>
                                    </v-btn>
                                    <p class="subtitle-2 mt-3 ml-1 mr-1 responsive--text">{{ post.count_comments }}</p>
                                </v-card-actions>
                            </v-card>
                        </v-row>
                    </v-col>
                </v-row>
                <v-divider></v-divider>
            </v-col>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                activeMode: "Все посты"
            }
        },
        methods: {
            getCategory: function(id, content) {
                this.activeMode = content;
                if (id === 0) {
                    this.$store.dispatch('GET_POSTS');
                } else {
                    this.$store.dispatch('GET_CATEGORY_POSTS', id);
                }
            }
        },
        mounted() {
            this.$store.dispatch('GET_POSTS');
            this.$store.dispatch('GET_CATEGORIES');
        },
        computed: {
            ...mapGetters(['POSTS', 'CATEGORIES']),
            /**
             * @return {string}
             */
            ACTIVE_MODE() { return this.activeMode }
        }
    }
</script>

<style scoped>
    img {
        max-width: 100%;
    }

    @media (min-width : 1905px) {
        .responsive--text {
            font-size : 2rem !important;
        }
        .responsive--image {
            height : 52px !important;
            width : 52px !important;
        }
    }
</style>
