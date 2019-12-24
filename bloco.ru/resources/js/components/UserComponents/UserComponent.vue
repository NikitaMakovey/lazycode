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
                        <v-img :src="USERS[0].user_image"></v-img>
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
                                <span class="title profile--text teal--color">{{ USERS[0].name }}</span>
                                <v-btn text icon class="route__style profile--text edit--button"
                                       :to="{ name: 'users.edit', params: { id: this.$store.getters.USER_ID } }"
                                       v-if="this.$route.params.id == this.$store.getters.USER_ID"
                                >
                                    <v-icon class="edit--icon">mdi-fountain-pen-tip</v-icon>
                                </v-btn>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                class="profile--text no-route-link--color"
                            >
                                {{ USERS[0].specialization }}
                            </v-list-item-subtitle>
                            <v-list-item-action-text
                                class="profile--text route-link--color"
                            >
                                @{{ USERS[0].username }}
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
                        :key="item"
                    >
                        {{ item }}
                    </v-tab>
                </v-tabs>
                <v-tabs-items v-model="tab">
                    <v-tab-item
                        v-for="item in items"
                        :key="item"
                    >
                        <v-card flat>
                            <template v-if="item === 'О себе'">
                                <p class="subtitle-1 no-route-link--color pa-2">{{ USERS[0].about }}</p>
                            </template>
                            <template v-else-if="item === 'Посты'">
                                <post-component :posts="USER_POSTS"></post-component>
                            </template>
                            <template v-else>
                                <comment-component :comments="USER_COMMENTS"></comment-component>
                            </template>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';
    import PostComponent from "./ProfileComponents/PostComponent";
    import CommentComponent from "./ProfileComponents/CommentComponent";

    export default {
        data () {
            return {
                tab: null,
                items: [
                    'О себе', 'Посты', 'Комментарии'
                ]
            }
        },
        components: {
            'post-component' : PostComponent,
            'comment-component' : CommentComponent
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$route.params.id);
            this.$store.dispatch('GET_USER_POSTS', this.$route.params.id);
            this.$store.dispatch('GET_USER_COMMENTS', this.$route.params.id);
        },
        computed: {
            ...mapGetters(['USERS', 'USER_COMMENTS', 'USER_POSTS'])
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
