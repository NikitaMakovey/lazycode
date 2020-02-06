<template>
    <div class="album">
        <v-container
            id="scroll-target"
            style="max-height: 94vh"
            class="overflow-y-auto"
        >
            <div class="row" style="height: 94vh">
                <v-row>
                    <v-spacer></v-spacer>
                    <v-col cols="12" sm="10" md="10" lg="9" xl="7" class="post-bg pa-2">
                        <v-row class="pa-4">
                            <v-col cols="12" class="mb-1">
                                <v-row class="my-0">
                                    <v-btn icon small class="route__style mr-2"
                                           :to="{ name: 'user', params: { id: POST.author_id } }" exact
                                    >
                                        <v-avatar size="32px" item>
                                            <v-img :src="POST.user_image" alt="#UI">
                                            </v-img>
                                        </v-avatar>
                                    </v-btn>
                                    <span class="mx-1">
                                        <router-link :to="{ name: 'user', params: { id: POST.author_id }}"
                                                     class="route__style route-link--color"
                                        >
                                            @{{ POST.username }}
                                        </router-link>
                                    </span>
                                    <span class="mx-1">{{ $moment(POST.created_at).format("LL") }}</span>
                                </v-row>
                            </v-col>
                            <v-col cols="12" class="mb-1 py-0">
                                <v-row class="py-0 my-0">
                                    <p class="title no-route-link--color mr-1 my-0">
                                        {{ POST.title }}
                                    </p>
                                    <v-btn text icon class="route__style ml-1"
                                           :to="{ name: 'posts.edit', params: { id: POST.id } }"
                                           v-if="POST.author_id == $store.getters.ID"
                                    >
                                        <v-icon>mdi-fountain-pen-tip</v-icon>
                                    </v-btn>
                                </v-row>
                            </v-col>
                            <v-col cols="12" class="mb-1 py-0">
                                <v-row class="py-0 my-0">
                                    <v-chip
                                        class="ma-0 subtitle-1"
                                        color="#50575B" dark
                                        :to="{ name: 'category', params: { slug: POST.slug } }"
                                    >
                                        {{ POST.name }}
                                    </v-chip>
                                </v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-img :src="POST.image" style="height: auto; max-width: 100%"></v-img>
                            </v-col>
                            <v-col cols="12">
                                <v-row v-html="POST.body" class="post-body--html"></v-row>
                            </v-col>
                            <v-col cols="12">
                                <v-row>
                                    <div>
                                        <strong class="title">Теги: </strong>
                                        <template v-for="tag in POST_TAGS">
                                            <v-chip
                                                class="my-0 mx-1 subtitle-1"
                                                color="#50325B" dark
                                            >
                                                {{ tag.name }}
                                            </v-chip>
                                        </template>
                                    </div>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-spacer></v-spacer>
                </v-row>
            </div>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {

            }
        },
        methods: {

        },
        mounted() {
            this.$store.dispatch('GET_POST', this.$route.params.id);
        },
        computed: {
            ...mapGetters(['POST', 'POST_COMMENTS', 'POST_TAGS'])
        }
    }
</script>

<style scoped>
    .post-bg {
        background-image: linear-gradient( 109.6deg,  rgba(204,228,247,1) 11.2%, rgba(237,246,250,1) 100.2% );
    }
</style>
