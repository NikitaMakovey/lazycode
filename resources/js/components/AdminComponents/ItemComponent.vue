<template>
    <v-col cols="12" class="post-bg pa-2">
        <v-row class="pa-0 ma-0">
            <v-col cols="12" class="mb-0">
                <v-row class="ma-0">
                    <v-btn icon small class="route__style mr-2"
                           :to="{ name: 'user.about', params: { id: POST.author_id } }" exact
                    >
                        <v-avatar size="32px" item>
                            <v-img :src="POST.user_image" alt="#UI">
                            </v-img>
                        </v-avatar>
                    </v-btn>
                    <span class="mx-1">
                            <router-link :to="{ name: 'user.about', params: { id: POST.author_id }}"
                                         class="route__style route-link--color"
                            >
                                @{{ POST.username }}
                            </router-link>
                        </span>
                </v-row>
            </v-col>
            <v-col cols="12" class="ma-0 pt-0">
                <span>{{ $moment(POST.created_at).format("LL") }}</span>
            </v-col>
            <v-col cols="12" class="mb-1 py-0">
                <v-row class="py-0 ma-0">
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
                <v-row class="py-0 ma-0">
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
                <v-row v-html="POST.body" class="post-body--html mx-0"></v-row>
            </v-col>
            <v-col cols="12">
                <v-row class="mx-0">
                    <div>
                        <strong class="title">Теги: </strong>
                        <template v-for="tag in POST_TAGS">
                            <v-chip
                                class="my-1 mx-1 subtitle-1"
                                color="#937666" dark small
                            >
                                {{ tag.name }}
                            </v-chip>
                        </template>
                    </div>
                </v-row>
            </v-col>
        </v-row>
    </v-col>
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
            ...mapGetters(['POST', 'POST_TAGS'])
        }
    }
</script>

<style scoped>
    .post-bg {
        background-image: linear-gradient( 109.6deg,  rgba(204,228,247,1) 11.2%, rgba(237,246,250,1) 100.2% );
    }
</style>
