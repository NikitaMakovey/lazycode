<template>
    <v-app id="inspire">
        <v-content>
            <v-container fluid class="fill-height">
                <v-row align="center" justify="center">
                    <v-col cols="5">
                        <v-card >
                            <v-toolbar color="#393E41" dark flat height="auto">
                                <v-toolbar-title color="#393E41" class="#F6F7EB--text" dark><strong class="display-4">404</strong> СТРАНИЦА НЕ НАЙДЕНА</v-toolbar-title>
                                <v-spacer/>
                            </v-toolbar>
                            <v-card-actions>
                                <v-btn dark color="#393E41" class="ma-2" @click="goBack">НАЗАД</v-btn>
                                <v-btn dark color="#393E41" class="ma-2" @click="goHome">НА ГЛАВНУЮ</v-btn>
                                <v-spacer/>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: 'NotFound',
        methods: {
            goBack() {
                this.$router.go(-1);
            },
            goHome() {
                this.$router.push({ path: '/' });
            }
        }
    }
</script>

<style scoped>

</style>
