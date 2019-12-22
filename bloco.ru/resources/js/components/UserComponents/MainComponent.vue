<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10">
            <v-row class="pa-2 ma-0">
                <p class="display-1">Пользователи</p>
            </v-row>
            <v-divider></v-divider>
            <v-col cols="12" v-for="user in USERS" :key="user.user_id" class="my-0 py-0">
                <v-row>
                    <v-col cols="8">
                        <v-btn icon large class="route__style" :to="{ name: 'user', params: { id: user.user_id } }" exact>
                            <v-avatar size="3rem" item>
                                <v-img :src="user.user_image" alt="#UI">
                                </v-img>
                            </v-avatar>
                        </v-btn>
                        <span class="title">{{ user.name }}</span>
                        <span class="title">
                            <router-link :to="{ name: 'user', params: { id: user.user_id }}" class="route__style">
                                @{{ user.username }}
                            </router-link>
                        </span>
                    </v-col>
                    <v-col cols="4">
                        <v-row justify="end">
                            <p class="title mt-3 mr-2">{{ user.rating > 0 ? "+" : ""}}{{ user.rating }}</p>
                            <v-icon>mdi-diamond-stone</v-icon>
                        </v-row>
                    </v-col>
                </v-row>
            </v-col>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        mounted() {
            this.$store.dispatch('GET_USERS');
        },
        computed: {
            ...mapGetters(['USERS'])
        }
    }
</script>

<style scoped>

</style>
