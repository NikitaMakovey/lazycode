<template>
    <div class="user-posts">
        <div class="posts-list">
            <ul class="post-area" v-for="post in posts" :key="post.id">
                <li class="post-space">
                    <article class="post-item">
                        <header class="post-metadata"></header>
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
</template>

<script>
    export default {
        name: "UserPosts",
        data() {
            return {
                posts : {}
            }
        },
        methods: {
            getPosts() {
                let id_ = this.$route.params.id;
                let apiRoute = "/api/users/" + id_ + "/posts";
                axios.get(apiRoute).then(({data}) => (this.posts = data));
            },
        },
        created() {
            this.getPosts();
        }
    }
</script>

<style scoped>

</style>
