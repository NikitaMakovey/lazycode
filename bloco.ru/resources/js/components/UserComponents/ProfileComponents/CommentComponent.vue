<template>
    <div>
        <v-col cols="12" class="comments--aria pa-4"
               v-for="comment in comments" :key="comment.id"
        >
            <v-row class="pa-2 mb-0">
                <v-col cols="12" class="mb-0">
                    <v-row>
                        <p class="title">
                            <router-link class="route__style"
                                   :to="{ name: 'post', params: { id: comment.post_id } }" exact
                            >
                                {{ comment.post_title }}
                            </router-link>
                        </p>
                    </v-row>
                </v-col>
                <v-col cols="12">
                    <v-row v-html="comment.comment_body" class="post-body--html"></v-row>
                </v-col>
                <v-col cols="12">
                    <v-row>
                        <v-btn text icon>
                            <v-icon>mdi-star-four-points</v-icon>
                        </v-btn>
                        <p class="subtitle-2 mt-2 ml-1 mr-1">
                            {{ comment.rating > 0 ? "+" : ""}}{{ comment.rating }}
                        </p>
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
            comments: Array
        }
    }
</script>

<style scoped>

</style>
