<template>
    <div class="container">
        <div class="index-user">
            <div class="page-header">
                <div class="header-title">
                    <span class="header-title-text">Пользователи</span>
                </div>
            </div>
            <div class="search-bar">
                <!-- Search form -->
                <form class="form-inline active-cyan active-cyan-2">
                    <input v-model="keyword" class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Найти пользователя"
                           aria-label="Search">
                    <i class="fas fa-search" aria-hidden="true"></i>
                </form>
                <hr>
            </div>
            <div class="users-list">
                <ul class="user-area" v-for="user in USERS" :key="user.user_id">
                    <li class="user-content">
                        <div class="user-info-data">
                            <router-link :to="{ name: 'user', params: { id: user.user_id }}" class="vue-link">
                                <img :src="user.user_image" alt="" class="user-icon-item" style="display: inline-block">
                            </router-link>
                            <div class="user-text-data" style="display: inline-block">
                                <div class="user-meta-data" style="display: block">
                                    <div class="user-name" style="display: inline-block">
                                        <span>{{ user.name }}</span>
                                    </div>
                                    <div class="user-username" style="display: inline-block">
                                        <router-link :to="{ name: 'user', params: { id: user.user_id }}" class="user-username-link">
                                            @{{ user.username }}
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <span>{{ user.rating }} <i class="fas fa-splotch"></i></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar"></div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                keyword : '',
            }
        },
        mounted() {
            this.$store.dispatch('GET_USERS');
        },
        computed: {
            ...mapGetters(['USERS']),
            /*searchUsers() {
                return this.USERS.filter(
                    (user) => {
                        return user.username.toLowerCase().includes(this.keyword.toLowerCase());
                    }
                );
            }*/
        }
    }
</script>
