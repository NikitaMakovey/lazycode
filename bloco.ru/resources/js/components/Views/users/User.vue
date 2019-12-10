<template>
    <div class="container">
        <div class="user-field">
            <header class="user-header">
                <div style="display: block">
                    <div class="user-image" style="display: inline-block">
                        <img :src="USERS[0].user_image" alt="" class="user-icon">
                    </div>
                    <div class="user-points" style="display: inline-block"></div>
                </div>
                <div style="display: block">
                    <div class="user-name" style="display: inline-block">
                        <span>{{ USERS[0].name }} </span>
                    </div>
                    <div class="user-username" style="display: inline-block">
                        <router-link :to="{ name: 'user', params : { id: this.$route.params.id }}"
                                     class="user-username-link vue-link">
                            @{{ USERS[0].username }}
                        </router-link>
                    </div>
                </div>
                <div style="display: block">
                    <span>{{ USERS[0].specialization }} </span>
                    <span><i class="fas fa-splotch"></i> {{ USERS[0].rating }}</span>
                </div>
            </header>
            <div class="user-info">
                <div class="user-sections">
                    <ul class="section-items">
                        <li class="section-item">
                            <a class="user-section">
                                <router-link :to="{ name: 'user.about' }">
                                    Профиль
                                </router-link>
                            </a>
                        </li>
                        <li class="section-item">
                            <a class="user-section">
                                <router-link :to="{ name: 'user.posts' }">
                                    Публикации
                                </router-link>
                            </a>
                        </li>
                        <li class="section-item">
                            <a class="user-section">
                                <router-link :to="{ name: 'user.comments' }">
                                    Комментарии
                                </router-link>
                            </a>
                        </li>
                    </ul>
                    <hr class="hr-user">
                </div>
                <div class="view-space">
                    <template>
                        <div class="user-about">
                            <span>
                                {{ USERS[0].about }}
                            </span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        mounted() {
            this.$store.dispatch('GET_USER', this.$route.params.id);
        },
        computed: {
            ...mapGetters(['USERS'])
        }
    }
</script>

<style scoped>

</style>
