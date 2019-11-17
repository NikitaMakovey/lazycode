<template>
    <div class="container">
        <div class="post-field">
            <header class="post-metadata"></header>
            <h1 class="post-title">
                {{ this.post.title }}
            </h1>
            <span class="post-category"></span>
            <div class="post-body">
                <div v-html="this.post.body" class="post-text"></div>
            </div>
            <footer class="post-footer"></footer>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                post : []
            }
        },
        methods: {
            loadPost() {
                let id_ = this.$route.params.id;
                let apiRoute = "/api/posts/" + id_;
                axios.get(apiRoute).then(({data}) => (this.post = data));
            }
        },
        mounted() {
            this.loadPost();
        }
    }
</script>

<style scoped>

</style>
