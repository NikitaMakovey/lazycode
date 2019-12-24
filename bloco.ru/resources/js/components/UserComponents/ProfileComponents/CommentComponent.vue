<template>
    <div>
        <v-col cols="12" class="comments--aria pa-4"
               v-for="comment in comments" :key="comment.id"
        >
            <v-row class="pa-2 mb-0">
                <v-col cols="12" class="mb-0 py-0">
                    <v-row class="py-0 my-0">
                        <p class="title py-0">
                            <router-link class="route__style route-link--color"
                                   :to="{ name: 'post', params: { id: comment.post_id } }" exact
                            >
                                {{ comment.post_title }}
                            </router-link>
                        </p>
                    </v-row>
                </v-col>
                <v-col cols="12" class="py-0">
                    <v-row class="post-body--html">
                        <span class="subtitle-1 no-route-link--color">{{ comment.comment_body }}</span>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <v-btn text icon>
                            <v-icon>mdi-star-four-points</v-icon>
                        </v-btn>
                        <p class="subtitle-2 mt-2 ml-1 mr-1 no-route-link--color">
                            {{ comment.rating > 0 ? "+" : ""}}{{ comment.rating }}
                        </p>
                    </v-row>
                </v-col>
            </v-row>
            <v-divider class="my-0"></v-divider>
        </v-col>
    </div>
</template>

<script>
    export default {
        props: {
            comments: Array
        }
    }
</script>

<style scoped>

</style>
