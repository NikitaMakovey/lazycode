<template>
    <div class="container">
        <div class="row">
            <div v-for="post in posts" :key="post.id">
                <router-link :to="{ name: 'post', params: { id: post.id } }" v-bind:id="post.id">
                    <div v-html="post.body"></div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts : {}
            }
        },
        methods: {
            loadPosts() {
                axios.get("api/posts").then(({data}) => (this.posts = data))
            }
        },
        created() {
            this.loadPosts();
        }
    }
</script>
