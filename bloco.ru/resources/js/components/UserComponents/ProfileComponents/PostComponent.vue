<template>
    <div>
        <v-col cols="12" v-for="post in posts" :key="post.post_id" class="pa-5">
            <v-row>
                <v-col cols="12" class="mb-0 py-0">
                    <v-row class="py-0 my-0">
                        <p class="title my-1">
                            <router-link class="route__style route-link--color" :to="{ name: 'post', params: { id: post.post_id }}">
                                {{ post.post_title }}
                            </router-link>
                        </p>
                    </v-row>
                </v-col>
                <v-col cols="12" class="ma-0 py-0">
                    <v-row class="my-0 py-0">
                        <v-chip
                            class="ma-0 subtitle-1"
                            color="#50575B" dark
                        >
                            {{ post.category }}
                        </v-chip>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-row v-html="post.post_body" class="post-body--html"></v-row>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <v-btn class="route__style" dark outlined color="#50575B"
                               :to="{ name: 'post', params: { id: post.post_id } }" exact
                        >
                            Читать весь пост
                        </v-btn>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <v-card class="px-2 py-0" outlined>
                            <v-card-actions>
                                <v-btn text icon>
                                    <v-icon>mdi-star-four-points</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-3 ml-1 mr-1">{{ post.rating > 0 ? "+" : ""}}{{ post.rating }}</p>
                                <v-btn icon>
                                    <v-icon>mdi-message-text</v-icon>
                                </v-btn>
                                <p class="subtitle-2 mt-3 ml-1 mr-1">{{ post.count_comments }}</p>
                            </v-card-actions>
                        </v-card>
                    </v-row>
                </v-col>
            </v-row>
            <v-divider></v-divider>
        </v-col>
    </div>
</template>

<script>
    export default {
        props: {
            posts: Array
        }
    }
</script>

<style scoped>

</style>
