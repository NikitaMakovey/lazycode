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
                <ul class="post-area" v-for="post in posts" :key="post.id">
                    <li class="post-space">
                        <article class="post-item">
                            <header class="post-metadata">
                                <div style="display: block">
                                    <div class="user-meta-icon" style="display: inline-block">
                                        <router-link :to="{ name: 'user', params: { id: post.author_id }}" class="vue-link">
                                            <img :src="getImage(post.author_id)" alt="#" class="user-icon-img">
                                        </router-link>
                                    </div>
                                    <div class="user-username" style="display: inline-block">
                                        <router-link :to="{ name: 'user', params: { id: post.author_id }}" class="username-item-link">
                                            @{{ getUsername(post.author_id) }}
                                        </router-link>
                                    </div>
                                </div>
                                <div class="category-block" style="display: block">
                                    <span class="meta-category">{{ getCategory(post.category_id) }}</span>
                                </div>
                            </header>
                            <h2 class="post-title">
                                <router-link class="vue-link" :to="{ name: 'post', params: { id: post.id }}">
                                    {{ post.title }}
                                </router-link>
                            </h2>
                            <span class="post-category"></span>
                            <div class="post-body">
                                <div v-html="post.body" class="post-text"></div>
                                <router-link class="vue-link-button" :to="{ name: 'post', params: { id: post.id }}">
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
                users : {},
                categories : {}
            }
        },
        methods: {
            loadPosts() {
                axios.get("/api/lazycode/posts").then(({data}) => (this.posts = data));
            },
            loadUsers() {
                axios.get("/api/lazycode/users").then(({data}) => (this.users = data));
            },
            loadCategories() {
                axios.get("/api/lazycode/categories").then(({data}) => (this.categories = data))
            },
            getUsername(id) {
                return this.users.find(x => x.id === id).username;
            },
            getImage(id) {
                return this.users.find(x => x.id === id).image;
            },
            getCategory(id) {
                return this.categories.find(x => x.id === id).name;
            }
        },
        created() {
            this.loadCategories();
            this.loadUsers();
            this.loadPosts();
        }
    }
</script>
