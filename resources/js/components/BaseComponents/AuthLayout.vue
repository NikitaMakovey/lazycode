<template>
    <v-app id="inspire" class="auth-background">
        <v-content>
            <v-container class="fill-height" fluid>
                <router-view></router-view>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        name: "AuthLayout"
    }
</script>

<style scoped>
    .auth-background {
        background-color: #8EC5FC;
        background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    }
</style>
