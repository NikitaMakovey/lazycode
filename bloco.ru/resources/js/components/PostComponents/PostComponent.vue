<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="8" sm="8" md="8" lg="8" xl="8">
            <v-row>
                <v-col cols="12" class="mb-0">
                    <v-row>
                        <v-btn icon small class="route__style mr-2"
                               :to="{ name: 'user', params: { id: POSTS[0].user_id } }" exact
                        >
                            <v-avatar size="32px" item>
                                <v-img :src="POSTS[0].user_image" alt="#UI">
                                </v-img>
                            </v-avatar>
                        </v-btn>
                        <span>
                            <router-link :to="{ name: 'user', params: { id: POSTS[0].user_id }}"
                                         class="route__style"
                            >
                                @{{ POSTS[0].username }}
                            </router-link>
                        </span>
                        <!--<span>{{ post.created_at }}</span>-->
                    </v-row>
                </v-col>
                <v-col cols="12" class="mb-0">
                    <v-row>
                        <p class="title">
                            {{ POSTS[0].post_title }}
                        </p>
                        <v-btn text icon class="route__style"
                               :to="{ name: 'posts.edit', params: { id: POSTS[0].post_id } }"
                               v-if="POSTS[0].user_id == this.$store.getters.USER_ID"
                        >
                            <v-icon>mdi-fountain-pen-tip</v-icon>
                        </v-btn>
                    </v-row>
                </v-col>
                <v-col cols="12" class="ma-0">
                    <v-row>
                        <div>
                            <span class="">{{ POSTS[0].category }}</span>
                        </div>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-row v-html="POSTS[0].post_body" class="post-body--html"></v-row>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <v-card class="px-2 py-0" outlined>
                            <v-card-actions>
                                <v-btn text icon @click="voteClick(1, POSTS[0].post_id, POSTS[0].user_id, true)">
                                    <v-icon>mdi-arrow-up-bold</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-3 ml-1 mr-1">
                                    {{ POSTS[0].rating > 0 ? "+" : ""}}{{ POSTS[0].rating }}
                                </p>
                                <v-btn text icon @click="voteClick(1, POSTS[0].post_id, POSTS[0].user_id, false)">
                                    <v-icon>mdi-arrow-down-bold</v-icon>
                                </v-btn>
                                <v-btn icon>
                                    <v-icon>mdi-message-text</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-3 ml-1 mr-1">
                                    {{ POSTS[0].count_comments }}
                                </p>
                            </v-card-actions>
                        </v-card>
                    </v-row>
                </v-col>
                <v-col cols="12" class="comments--aria"
                       v-for="comment in POST_COMMENTS" :key="comment.id"
                >
                    <v-row style="border: 2px solid #537d7b" class="pa-2 mb-0">
                        <v-col cols="12" class="mb-0">
                            <v-row>
                                <v-btn icon small class="route__style mr-2"
                                       :to="{ name: 'user', params: { id: comment.user_id } }" exact
                                >
                                    <v-avatar size="32px" item>
                                        <v-img :src="comment.user_image" alt="#UI">
                                        </v-img>
                                    </v-avatar>
                                </v-btn>
                                <span>
                                <router-link :to="{ name: 'user', params: { id: comment.user_id }}"
                                             class="route__style"
                                >
                                    @{{ comment.username }}
                                </router-link>
                            </span>
                                <!--<span>{{ post.created_at }}</span>-->
                            </v-row>
                        </v-col>
                        <v-col cols="12">
                            <v-row v-html="comment.comment_body" class="post-body--html"></v-row>
                        </v-col>
                        <v-col cols="12">
                            <v-row>
                                <v-btn text icon @click="voteClick(2, comment.id, comment.user_id, true)">
                                    <v-icon>mdi-arrow-up-bold</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-2 ml-1 mr-1">
                                    {{ comment.rating > 0 ? "+" : ""}}{{ comment.rating }}
                                </p>
                                <v-btn text icon @click="voteClick(2, comment.id, comment.user_id, false)">
                                    <v-icon>mdi-arrow-down-bold</v-icon>
                                </v-btn>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        methods: {
            voteClick: function (typeId, sourceId, directId, voteValue) {
                let data = {
                    type_id : typeId,
                    source_id : sourceId,
                    user_id : this.$store.getters.USER_ID,
                    direct_id : directId,
                    vote : voteValue
                };
                this.$store.dispatch('SET_VOTE', data);
            }
        },
        mounted() {
            this.$store.dispatch('GET_POST', this.$route.params.id);
            this.$store.dispatch('GET_POST_COMMENTS', this.$route.params.id);
        },
        computed: {
            ...mapGetters(['POSTS', 'POST_COMMENTS'])
        }
    }
</script>

<style scoped>

</style>
