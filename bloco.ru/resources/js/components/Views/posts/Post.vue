<template>
    <div class="container">
        <div class="post-field">
            <header class="post-metadata">
                <header class="post-metadata">
                    <div style="display: block">
                        <div class="user-meta-icon" style="display: inline-block">
                            <router-link :to="{ name: 'user', params: { id: this.post.author_id }}" class="vue-link">
                                <img :src="getImage(this.post.author_id)" alt="#" class="user-icon-img">
                            </router-link>
                        </div>
                        <div class="user-username" style="display: inline-block">
                            <router-link :to="{ name: 'user', params: { id: this.post.author_id }}" class="username-item-link">
                                @{{ getUsername(this.post.author_id) }}
                            </router-link>
                        </div>
                    </div>
                    <div class="category-block" style="display: block">
                        <span class="meta-category">{{ getCategory(this.post.category_id) }}</span>
                    </div>
                </header>
            </header>
            <h1 class="post-title">
                {{ this.post.title }}
            </h1>
            <span class="post-category"></span>
            <div class="post-body">
                <div v-html="this.post.body" class="post-text"></div>
            </div>
            <footer class="post-footer">
                <router-link class="vue-link-button" :to="{ name: 'posts.edit', params: { id: this.post.id }}">
                    <button type="button" class="btn user-button">
                        Редактировать пост
                    </button>
                </router-link>
            </footer>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                post: [],
                users: {},
                categories: {}
            }
        },
        methods: {
            loadPost() {
                let id_ = this.$route.params.id;
                let apiRoute = "/api/lazycode/posts/" + id_;
                axios.get(apiRoute).then(({data}) => (this.post = data));
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
        mounted() {
            this.loadPost();
            this.loadCategories();
            this.loadUsers();
        }
    }
</script>

<style scoped>

</style>
