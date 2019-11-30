<template>
    <div class="container">
        <div class="index-post">
            <div class="page-header">
                <div class="header-title">
                    <span class="header-title-text">Все посты</span>
                </div>
            </div>
            <div class="tabs">
                <hr>
            </div>
            <div class="posts-list">
                <ul class="post-area" v-for="post in posts" :key="post.post_id">
                    <li class="post-space">
                        <article class="post-item">
                            <header class="post-metadata">
                                <div style="display: block">
                                    <div class="user-meta-icon" style="display: inline-block">
                                        <router-link :to="{ name: 'user', params: { id: post.user_id }}" class="vue-link">
                                            <img :src="post.user_image" alt="#" class="user-icon-img">
                                        </router-link>
                                    </div>
                                    <div class="user-username" style="display: inline-block">
                                        <router-link :to="{ name: 'user', params: { id: post.user_id }}" class="username-item-link">
                                            @{{ post.username }}
                                        </router-link>
                                    </div>
                                </div>
                                <div class="category-block" style="display: block">
                                    <span class="meta-category">{{ post.category }}</span>
                                </div>
                            </header>
                            <h2 class="post-title">
                                <router-link class="vue-link" :to="{ name: 'post', params: { id: post.post_id }}">
                                    {{ post.post_title }}
                                </router-link>
                            </h2>
                            <span class="post-category"></span>
                            <div class="post-body">
                                <div v-html="post.post_body" class="post-text"></div>
                                <div>
                                    <span>{{ post.rating }} <i class="fas fa-splotch"></i></span>
                                    <span>{{ post.count_comments }} <i class="fas fa-comment"></i></span>
                                </div>
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
        <div class="sidebar"></div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                posts : {},
            }
        },
        methods: {
            loadPosts() {
                axios.get("/api/lazycode/posts").then(({data}) => (this.posts = data));
            }
        },
        created() {
            this.loadPosts();
        }
    }
</script>
