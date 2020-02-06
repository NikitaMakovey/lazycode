<template>
    <v-row>
        <v-col cols="12" lg="12" class="pa-0 ma-0">
            <v-card class="data-height pl-1">
                <v-col cols="12">
                    <v-row>
                        <v-col cols="12" sm="3" md="3" class="pa-2 item-group-height divider-right">
                            <v-list rounded>
                                <v-subheader class="list-subheader">КАМОРКА АДМИНА</v-subheader>
                                <v-list-item-group class="mt-1">
                                    <v-list-item
                                        :to="{ name: '#' }"
                                        exact
                                        class="my-1"
                                    >
                                        <v-list-item-icon class="mr-1">
                                            <v-icon>mdi-badminton</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title v-text="item"></v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item
                                        :to="{ name: 'main' }"
                                        exact
                                    >
                                        <v-list-item-icon class="mr-1">
                                            <v-icon>mdi-exit-run</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-content>
                                            <v-list-item-title>ВЫХОД</v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-col>
                        <v-col cols="12" sm="9" md="9" class="pa-2">
                            <router-view></router-view>
                        </v-col>
                    </v-row>
                </v-col>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                item: 'КЛАДОВКА'
            }
        },
        mounted() {

        },
        computed: {

        }
    }
</script>

<style scoped>
    .divider-right {
        border-right: 1px solid gray;
    }
    @media screen and (max-width: 700px) {
        .divider-right {
            border-right: none;
            border-bottom: 1px solid gray;
        }
        .item-group-height {
            height: auto !important;
        }
    }
    .list-subheader {
        font-size: 1.5rem;
        background-color: #1d2124;
        color: #f7efd5;
        border-radius: 1.6rem;
    }
    * {
        text-decoration: none !important;
    }
    .data-height {
        height: 100vh;
    }
    .item-group-height {
        height: 96vh;
    }
    @media screen and (max-width: 700px) {
    }
</style>
