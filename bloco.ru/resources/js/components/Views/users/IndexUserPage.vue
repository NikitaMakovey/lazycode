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
                <ul class="user-area" v-for="user in searchUsers" :key="user.id">
                    <li class="user-content">
                        <div class="user-info-data">
                            <router-link :to="{ name: 'user', params: { id: user.id }}" class="vue-link">
                                <img :src="user.image" alt="" class="user-icon-item" style="display: inline-block">
                            </router-link>
                            <div class="user-text-data" style="display: inline-block">
                                <div class="user-meta-data" style="display: block">
                                    <div class="user-name" style="display: inline-block">
                                        <span>{{ user.name }}</span>
                                    </div>
                                    <div class="user-username" style="display: inline-block">
                                        <router-link :to="{ name: 'user', params: { id: user.id }}" class="user-username-link">
                                            @{{ user.username }}
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar"></div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                keyword : '',
                users : []
            }
        },
        methods: {
            loadUsers() {
                axios.get("api/lazycode/users").then(({data}) => (this.users = data))
            }
        },
        created() {
            this.loadUsers();
        },
        computed: {
            searchUsers() {
                return this.users.filter(
                    (user) => {
                        return user.username.toLowerCase().includes(this.keyword.toLowerCase());
                    }
                );
            }
        }
    }
</script>
