<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10" class="pa-0 ma-0">
            <v-card>
                <v-col
                    align-self="start"
                    class="pa-0"
                    cols="12"
                >
                    <v-avatar
                        class="profile"
                        color="grey"
                        size="164"
                        tile
                    >
                        <v-img :src="USER.image"></v-img>
                    </v-avatar>
                </v-col>
                <v-col class="px-1 py-0">
                    <v-list-item
                        color="#393E41"
                        dark
                        class="px-0"
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <span class="title profile--text teal--color">{{ USER.name }}</span>
                                <v-btn text icon class="route__style profile--text edit--button"
                                       :to="{ name: 'users.edit', params: { id: $store.getters.ID } }"
                                       v-if="$route.params.id == $store.getters.ID"
                                >
                                    <v-icon class="edit--icon">mdi-fountain-pen-tip</v-icon>
                                </v-btn>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                class="profile--text no-route-link--color"
                            >
                                {{ USER.specialization }}
                            </v-list-item-subtitle>
                            <v-list-item-action-text
                                class="profile--text route-link--color"
                            >
                                @{{ USER.username }}
                            </v-list-item-action-text>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>
                <v-tabs
                    v-model="tab"
                    background-color="transparent"
                    class="profile--text"
                    grow
                >
                    <v-tab
                        v-for="item in items"
                        :key="item.name"
                        :to="{ name: item.route }"
                    >
                        {{ item.name }}
                    </v-tab>
                </v-tabs>
                <v-col cols="12">
                    <v-card flat>
                        <router-view></router-view>
                    </v-card>
                </v-col>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data () {
            return {
                tab: null,
                items: this.$route.name.substring(0, 2) === 'me' ? [
                    { name: 'О себе', route: 'me.about' },
                    { name: 'Статьи', route: 'me.posts' },
                    { name: 'Комментарии', route: 'me.comments' }
                ] : [
                    { name: 'О себе', route: 'user.about' },
                    { name: 'Статьи', route: 'user.posts' },
                    { name: 'Комментарии', route: 'user.comments' }
                ]
            }
        },
        methods: {
            updateRouter(val){
                console.log(val);
                this.$router.push(val)
            }
        },
        mounted() {
            if (this.$route.name.substring(0, 2) === 'me') {
                this.$store.dispatch('GET_USER', this.$store.getters.ID);
            } else {
                this.$store.dispatch('GET_USER', this.$route.params.id);
            }
        },
        computed: {
            ...mapGetters(['USER'])
        }
    }
</script>

<style scoped>
    .profile--text {

    }
    .edit--button {
        height: 2rem;
        width: 2rem;
    }
    .edit--icon {
        font-size: 1rem;
    }
</style>
