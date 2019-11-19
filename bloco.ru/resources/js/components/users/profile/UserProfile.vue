<template>
    <div class="user-about">
        <span>
            {{ this.user.about }}
        </span>
    </div>
</template>

<script>
    export default {
        name: "UserProfile",
        data() {
            return {
                user : []
            }
        },
        methods: {
            getUser() {
                let id_ = this.$route.params.id;
                let apiRoute = "/api/users/" + id_;
                axios.get(apiRoute).then(({data}) => (this.user = data));
            }
        },
        mounted() {
            this.getUser();
        }
    }
</script>

<style scoped>

</style>
