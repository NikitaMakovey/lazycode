<template>
    <v-footer
        dark
        padless
    >
        <v-card
            flat
            tile
            width="100%"
            class="#393E41 #F6F7EB--text text-center"
        >
            <v-card-text>
                <v-btn
                    v-for="icon in icons"
                    :key="icon"
                    class="mx-4 white--text"
                    icon
                >
                    <v-icon size="24px">{{ icon }}</v-icon>
                </v-btn>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-text class="white--text">
                {{ new Date().getFullYear() }} — <strong>Lazycode</strong>
            </v-card-text>
        </v-card>
    </v-footer>
</template>

<script>
    export default {
        data() {
            return {
                icons: [
                    'fab fa-facebook',
                    'fab fa-twitter',
                    'fab fa-google-plus',
                    'fab fa-linkedin',
                    'fab fa-instagram',
                ]
            }
        }
    }
</script>

<style scoped>

</style>
