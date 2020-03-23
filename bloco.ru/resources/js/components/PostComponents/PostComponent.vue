<template>
    <v-row class="ma-0 pa-0">
        <v-spacer></v-spacer>
        <v-col cols="12" sm="10" md="10" lg="9" xl="7" class="post-bg pa-2">
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
                               :to="{ name: 'post.edit', params: { id: POST.id } }"
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
                    <v-row class="mx-0">
                        <div>
                            <strong class="title">Теги: </strong>
                            <template v-for="tag in POST_TAGS">
                                <v-chip
                                    class="my-1 mx-1 subtitle-1"
                                    color="#937666" dark small
                                >
                                    {{ tag.name }}
                                </v-chip>
                            </template>
                        </div>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-row class="mx-0">
                        <v-card class="px-2 py-0" outlined>
                            <v-card-actions>
                                <v-btn text icon @click="voteClick(1, POST.id, 1)"
                                       :class="$store.getters.ACCESS_TOKEN != null && CLICKED == 1 ? 'vote__btn-up' : 'vote__btn-default'"
                                >
                                    <v-icon>mdi-arrow-up-bold</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-3 ml-1 mr-1">
                                    {{ SUM_VOTES > 0 ? "+" : "" }}{{ SUM_VOTES == null ? 0 : SUM_VOTES }}
                                </p>
                                <v-btn text icon @click="voteClick(1, POST.id, -1)"
                                       :class="$store.getters.ACCESS_TOKEN != null && CLICKED == -1 ? 'vote__btn-down' : 'vote__btn-default'"
                                >
                                    <v-icon>mdi-arrow-down-bold</v-icon>
                                </v-btn>
                                <v-btn icon>
                                    <v-icon>mdi-message-text</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-3 ml-1 mr-1">
                                    {{ COUNT_COMMENTS }}
                                </p>
                            </v-card-actions>
                        </v-card>
                    </v-row>
                </v-col>
                <v-col cols="12" class="comment--input pa-0" v-if="$store.getters.ID">
                    <v-form @submit.prevent="postComment">
                        <v-container fluid class="py-0">
                            <v-row class="mx-0">
                                <v-col cols="12" class="pa-0">
                                    <v-textarea
                                        v-model="current_comment"
                                        color="teal"
                                    >
                                        <template v-slot:label>
                                            <div>
                                                Ваш комментарий
                                            </div>
                                        </template>
                                    </v-textarea>
                                    <v-btn dark color="#50575B" type="submit">Отправить</v-btn>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-col>
                <v-col cols="12" class="comments--aria mt-2"
                       v-for="comment in POST_COMMENTS" :key="comment.id"
                >
                    <v-row class="mb-0 pa-0 mx-0">
                        <v-col cols="12" class="mb-0 pa-0">
                            <v-row class="mx-0">
                                <v-btn icon small class="route__style mr-2"
                                       :to="{ name: 'user', params: { id: comment.author_id } }" exact
                                >
                                    <v-avatar size="32px" item>
                                        <v-img :src="comment.image" alt="#UI">
                                        </v-img>
                                    </v-avatar>
                                </v-btn>
                                <span>
                                    <router-link :to="{ name: 'user', params: { id: comment.author_id }}"
                                                 class="route__style route-link--color"
                                    >
                                        @{{ comment.username }}
                                    </router-link>
                                </span>
                            </v-row>
                        </v-col>
                        <v-col cols="12" class="px-0">
                            <span>{{ $moment(comment.created_at).format("LL") }}</span>
                        </v-col>
                        <v-col cols="12" class="pa-0">
                            <v-row class="post-body--html mx-0">
                                <span class="subtitle-1">{{ comment.body }}</span>
                            </v-row>
                        </v-col>
                        <v-col cols="12" class="pa-0">
                            <v-row class="mx-0">
                                <v-btn text icon @click="voteClick(2, comment.id, 1)">
                                    <v-icon :class="comment.code == 1 ? upClass : defaultClass">mdi-arrow-up-bold</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-2 ml-1 mr-1">
                                    {{ comment.sum_votes > 0 ? "+" : "" }}{{ comment.sum_votes == null ? 0 : comment.sum_votes }}
                                </p>
                                <v-btn text icon @click="voteClick(2, comment.id, -1)">
                                    <v-icon :class="comment.code == -1 ? downClass : defaultClass">mdi-arrow-down-bold</v-icon>
                                </v-btn>
                                <v-btn text icon @click="deleteComment(comment.id)"
                                       v-if="comment.author_id == $store.getters.ID"
                                >
                                    <v-icon>mdi-trash-can</v-icon>
                                </v-btn>
                            </v-row>
                        </v-col>
                    </v-row>
                    <v-divider class="ma-0"></v-divider>
                </v-col>
            </v-row>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios';

    export default {
        data() {
            return {
                current_comment: null,
                upClass: 'vote__btn-up',
                downClass: 'vote__btn-down',
                defaultClass: 'vote__btn-default',
            }
        },
        methods: {
            voteClick: function (type_id, source_id, vote) {
                if (this.$store.getters.ID) {
                    let data = {
                        type_id : type_id,
                        source_id : source_id,
                        vote : vote
                    };
                    let token = this.$store.getters.ACCESS_TOKEN;
                    let config = {
                        headers: {
                            Authorization: token
                        }
                    };
                    let url = '/api/v1/votes';
                    axios.post(url, data, config).then((response) => {
                        console.log(response);
                        if (type_id === 1) {
                            this.$store.dispatch('UPDATE_POST_VOTES', response.data);
                        } else {
                            let d = {
                                code: response.data.code,
                                sum_votes: response.data.sum_votes,
                                id: source_id
                            };
                            this.$store.dispatch('UPDATE_COMMENT_VOTES', d);
                        }
                    });
                } else {
                    this.$router.push({ name: 'auth.login' });
                }
            },
            postComment: function () {
                if (this.current_comment != '' && this.$store.getters.ACCESS_TOKEN) {
                    let token = this.$store.getters.ACCESS_TOKEN;
                    let config = {
                        headers: {
                            Authorization: token
                        }
                    };
                    let data = {
                        post_id: this.$route.params.id,
                        body: this.current_comment.toString()
                    };
                    this.current_comment = '';
                    let url = '/api/v1/comments';
                    axios.post(url, data, config).then((response) => {
                        this.$store.dispatch('POST_COMMENT', response.data);
                        this.$store.dispatch('UPDATE_POST_COMMENTS', response.data);
                    })
                }
            },
            deleteComment: function (id) {
                if (this.$store.getters.ACCESS_TOKEN) {
                    let token = this.$store.getters.ACCESS_TOKEN;
                    let config = {
                        headers: {
                            Authorization: token
                        }
                    };
                    let url = '/api/v1/comments/' + id;
                    axios.delete(url, config).then(() => {
                        this.$store.dispatch('DELETE_COMMENT', id);
                    })
                }
            }
        },
        mounted() {
            if (this.$store.getters.ACCESS_TOKEN != undefined && this.$store.getters.ACCESS_TOKEN != null) {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                let data = {
                    id: this.$route.params.id,
                    config: config
                };
                this.$store.dispatch('GET_AUTH_POST', data);
            } else {
                this.$store.dispatch('GET_POST', this.$route.params.id);
            }
        },
        computed: {
            ...mapGetters(['POST', 'POST_COMMENTS', 'POST_TAGS', 'COUNT_COMMENTS', 'SUM_VOTES', 'CLICKED'])
        }
    }
</script>

<style scoped>
    .post-bg {
        background-color: #ebebeb;
    }
    .vote__btn-up {
        color: #45aa6a !important;
    }
    .vote__btn-down {
        color: #aa574f !important;
    }
    .vote__btn-default {

    }
</style>
