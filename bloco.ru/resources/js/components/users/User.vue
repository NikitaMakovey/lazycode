<template>
    <div class="container">
        <div class="user-field">
            <header class="user-header">
                <div style="display: block">
                    <div class="user-image" style="display: inline-block">
                        <img :src="this.user.image" alt="" class="user-icon">
                    </div>
                    <div class="user-points" style="display: inline-block"></div>
                </div>
                <div style="display: block">
                    <div class="user-name" style="display: inline-block">
                        <span>{{ this.user.name }} </span>
                    </div>
                    <div class="user-username" style="display: inline-block">
                        <router-link :to="{ name: 'user', params : { id: this.$route.params.id }}"
                                     class="user-username-link vue-link">
                            @{{ this.user.username }}
                        </router-link>
                    </div>
                </div>
            </header>
            <div class="user-info">
                <div class="user-sections">
                    <ul class="section-items">
                        <li class="section-item"><a href="#" class="user-section">Профиль</a></li>
                        <li class="section-item"><a href="#" class="user-section">Публикации</a></li>
                        <li class="section-item"><a href="#" class="user-section">Комментарии</a></li>
                    </ul>
                    <hr class="hr-user">
                </div>
                <div class="user-about">
                    <span>{{ this.user.about }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user : []
            }
        },
        methods: {
            loadUser() {
                let id_ = this.$route.params.id;
                let apiRoute = "/api/users/" + id_;
                axios.get(apiRoute).then(({data}) => (this.user = data));
            }
        },
        mounted() {
            this.loadUser();
        }
    }
</script>

<style scoped>

</style>
