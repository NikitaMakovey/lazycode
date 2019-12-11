<template>
    <div class="container">
        <div class="user-field">
            <header class="user-header">
                <div style="display: block">
                    <div class="user-image" style="display: inline-block">
                        <img :src="USERS[0].user_image" alt="" class="user-icon">
                    </div>
                    <div class="user-points" style="display: inline-block"></div>
                </div>
                <div style="display: block">
                    <div class="user-name" style="display: inline-block">
                        <span>{{ USERS[0].name }} </span>
                    </div>
                    <div class="user-username" style="display: inline-block">
                        <router-link :to="{ name: 'user', params : { id: this.$route.params.id }}"
                                     class="user-username-link vue-link">
                            @{{ USERS[0].username }}
                        </router-link>
                    </div>
                </div>
                <div style="display: block">
                    <span>{{ USERS[0].specialization }} </span>
                    <span><i class="fas fa-splotch"></i> {{ USERS[0].rating }}</span>
                </div>
            </header>
            <div class="user-info">
                <div class="user-sections">
                    <ul class="section-items">
                        <li class="section-item">
                            <a class="user-section">
                                <router-link :to="{ name: 'user.about' }">
                                    Профиль
                                </router-link>
                            </a>
                        </li>
                        <li class="section-item">
                            <a class="user-section">
                                <router-link :to="{ name: 'user.posts' }">
                                    Публикации
                                </router-link>
                            </a>
                        </li>
                        <li class="section-item">
                            <a class="user-section">
                                <router-link :to="{ name: 'user.comments' }">
                                    Комментарии
                                </router-link>
                            </a>
                        </li>
                    </ul>
                    <hr class="hr-user">
                </div>
                <div class="view-space">

                    <template v-if="this.$route.params.id === '1'">
                        <div class="user-about">
                            <span>
                                {{ USERS[0].about }}
                            </span>
                        </div>
                    </template>

                    <template v-else-if="this.$route.params.id === 1">
                        <div class="user-posts">
                            <div class="posts-list">
                                <ul class="post-area" v-for="post in USER_POSTS" :key="post.id">
                                    <li class="post-space">
                                        <article class="post-item">
                                            <header class="post-metadata"></header>
                                            <h2 class="post-title">
                                                <router-link class="vue-link" :to="{ name: 'post', params: { id: post.post_id }}">
                                                    {{ post.post_title }}
                                                </router-link>
                                            </h2>
                                            <span class="post-category"></span>
                                            <div class="post-body">
                                                <div v-html="post.post_body" class="post-text"></div>
                                                <router-link class="vue-link-button" :to="{ name: 'post', params: { id: post.post_id }}">
                                                    <button type="button" class="btn user-button">
                                                        Читать весь пост
                                                    </button>
                                                </router-link>
                                            </div>
                                            <footer class="post-footer"></footer>
                                        </article>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>

                    <template v-else>
                        <div class="user-posts">
                            <div class="posts-list">
                                <ul class="post-area" v-for="comment in USER_COMMENTS" :key="comment.id">
                                    <li class="post-space">
                                        <article class="post-item">
                                            <header class="post-metadata"></header>
                                            <h2 class="post-title">
                                                <router-link class="vue-link" :to="{ name: 'post', params: { id: comment.post_id }}">
                                                    {{ comment.post_title }}
                                                </router-link>
                                            </h2>
                                            <span class="post-category"></span>
                                            <div class="post-body">
                                                <div v-html="comment.comment_body" class="post-text"></div>
                                            </div>
                                            <footer class="post-footer"></footer>
                                        </article>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                route_id: null
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$route.params.id);
            this.$store.dispatch('GET_USER_POSTS', this.$route.params.id);
            this.$store.dispatch('GET_USER_COMMENTS', this.$route.params.id);
            this.route_id = this.$route.params.id;
        },
        computed: {
            ...mapGetters(['USERS']),
            ...mapGetters(['USER_POSTS']),
            ...mapGetters(['USER_COMMENTS']),
        },
        watch: {
            // check change route
        }
    }
</script>

<style scoped>

</style>
