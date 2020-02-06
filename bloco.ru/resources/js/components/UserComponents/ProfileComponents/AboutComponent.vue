<template>
    <div>
        <template v-if="$store.getters.USER.about != null">
            <p class="title">
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

</style>
