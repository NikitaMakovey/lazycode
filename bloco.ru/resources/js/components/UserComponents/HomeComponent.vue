<template>
    <v-row class="xs-content-container">
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="10" lg="8" xl="6" class="pa-0 ma-0">
            <v-card class="my-2 xs-card-container">
                <v-col cols="12">
                    <v-row>
                        <v-col cols="12" sm="4" md="4" class="pa-1 divider-right">
                            <div class="xs__display-block">
                                <v-col cols="12" class="py-0">
                                    <p class="edit-title">Мой дом</p>
                                </v-col>
                                <v-divider></v-divider>
                            </div>
                            <v-list rounded>
                                <v-list-item-group v-model="item" color="primary">
                                    <v-list-item
                                        v-for="(item, i) in items"
                                        :key="i"
                                        :to="{ name: item.route }"
                                        exact
                                    >
                                        <v-list-item-icon class="mr-1">
                                            <v-icon v-text="item.icon"></v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item.text"></v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                        <v-col cols="12" sm="8" md="8" class="pa-2">
                            <div class="xs__display-none">
                                <v-col cols="12" class="py-0">
                                    <p class="edit-title">Мой дом</p>
                                </v-col>
                                <v-divider></v-divider>
                            </div>
                            <v-col cols="12" class="py-0">
                                <router-view></router-view>
                            </v-col>
                        </v-col>
                    </v-row>
                </v-col>
            </v-card>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    export default {
        data() {
            return {
                item: 1,
                items: [
                    { text: 'В публикациях', icon: 'mdi-account', route: 'home.publish' },
                    { text: 'В обработке', icon: 'mdi-email-edit', route: 'home.process' },
                    { text: 'Отказанные', icon: 'mdi-file-image', route: 'home.reject' },
                    { text: 'Черновики', icon: 'mdi-worker', route: 'home.draft' },
                ]
            }
        },
        mounted() {

        }
    }
</script>

<style scoped>
    @media screen and (max-width: 599px) {
        .divider-right {
            border-right: none !important;
            border-bottom: 1px solid gray;
        }
        .xs-content-container {
            margin: 0;
            padding: 0;
        }
        .xs-card-container {
            margin: 0 !important;
            border-radius: 0 !important;
        }
        .xs__display-none {
            display: none;
        }
        .xs__display-block {
            display: block;
        }
        .edit-title {
            font-size: 1.5rem !important;
        }
    }
    /* --- */

    @media screen and (min-width: 600px) and (max-width: 959px) {
        .xs-content-container {
            margin: 0;
        }
        .xs__display-none {
            display: block;
        }
        .xs__display-block {
            display: none;
        }
        .edit-title {
            font-size: 1.5rem !important;
        }
    }
    /* --- */

    @media screen and (min-width: 960px) and (max-width: 1263px) {
        .xs-content-container {
            margin: 0;
        }
        .xs__display-none {
            display: block;
        }
        .xs__display-block {
            display: none;
        }
        .edit-title {
            font-size: 1.5rem !important;
        }
    }
    /* --- */

    @media screen and (min-width: 1264px) {
        .xs-content-container {
            margin: 0;
        }
        .xs__display-none {
            display: block;
        }
        .xs__display-block {
            display: none;
        }
        .edit-title {
            font-size: 1.5rem !important;
        }
    }
    /* --- */

    * {
        text-decoration: none !important;
    }
    .edit-title {
        font-size: 2rem;
    }
    .divider-right {
        border-right: 1px solid gray;
    }
    @media screen and (min-width: 2000px) {
        .edit-title {
            font-size: 3rem;
        }
    }
</style>
