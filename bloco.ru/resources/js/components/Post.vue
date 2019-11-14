<template>
    <div class="container">
        <div class="row">
            Пост {{ this.$route.params.id }}
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                post : {}
            }
        },
        methods: {
            loadPost() {
                axios.get("api/posts/" + this.$route.params.id).then(({data}) => (this.post = data))
            }
        },
        created() {
            this.loadPost();
        }
    }
</script>

<style scoped>

</style>
