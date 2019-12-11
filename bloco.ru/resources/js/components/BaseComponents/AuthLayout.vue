<template>
    <v-app id="inspire" style="background-color: #F6F7EB">
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

</style>
