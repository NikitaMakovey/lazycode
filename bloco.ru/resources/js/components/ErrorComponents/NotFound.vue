<template>
    <div class="container">
        <div class="text-md-center">
            <h1 style="font-size: 8rem">404</h1>
            <h2 class="my-3 headline">Извините, страница не найдена.</h2>
            <div>
                <v-btn style="background-color: black" color="primary" @click="goBack">Вернуться назад</v-btn>
                <v-btn style="background-color: black" color="primary" @click="goHome">Вернуться на Главную страницу</v-btn>
            </div>
        </div>
    </div>
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
