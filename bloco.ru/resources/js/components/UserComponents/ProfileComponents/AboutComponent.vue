<template>
    <div>
        <template v-if="$store.getters.USER.about != null">
            <p class="title my-0">
                Я - {{ $store.getters.USER.specialization }}.
            </p>
            <p class="title mt-0">
                {{ $store.getters.USER.about }}
            </p>
        </template>
        <template v-else>
            <p class="title">
                Информация отсутствует - пользователь не рассказал о себе.
            </p>
        </template>
    </div>
</template>

<script>
    export default {

    }
</script>

<style scoped>
    .title {
        font-size: 1.2rem !important;
    }
</style>
