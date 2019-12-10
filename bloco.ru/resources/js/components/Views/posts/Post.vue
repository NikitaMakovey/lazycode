<template>
    <div class="container">
        <div class="post-field">
            <header class="post-metadata">
                <header class="post-metadata">
                    <div style="display: block">
                        <div class="user-meta-icon" style="display: inline-block">
                            <router-link :to="{ name: 'user', params: { id: POSTS[0].user_id }}" class="vue-link">
                                <img :src="POSTS[0].user_image" alt="#" class="user-icon-img">
                            </router-link>
                        </div>
                        <div class="user-username" style="display: inline-block">
                            <router-link :to="{ name: 'user', params: { id: POSTS[0].user_id }}" class="username-item-link">
                                @{{ POSTS[0].username }}
                            </router-link>
                        </div>
                    </div>
                    <div class="category-block" style="display: block">
                        <span class="meta-category">{{ POSTS[0].category }}</span>
                    </div>
                </header>
            </header>
            <h1 class="post-title">
                {{ POSTS[0].post_title }}
            </h1>
            <span class="post-category"></span>
            <div class="post-body">
                <div v-html="POSTS[0].post_body" class="post-text"></div>
                <div>
                    <span>{{ POSTS[0].rating }} <i class="fas fa-splotch"></i></span>
                    <span>{{ POSTS[0].count_comments }} <i class="fas fa-comment"></i></span>
                </div>
            </div>
            <footer class="post-footer">
                <router-link class="vue-link-button" :to="{ name: 'posts.edit', params: { id: POSTS[0].post_id }}">
                    <button type="button" class="btn user-button">
                        Редактировать пост
                    </button>
                </router-link>
            </footer>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        mounted() {
            this.$store.dispatch('GET_POST', this.$route.params.id);
        },
        computed: {
            ...mapGetters(['POSTS'])
        }
    }
</script>

<style scoped>

</style>
