<template>
    <div>
        <div>
            <p class="header-text">Подтверждение E-mail</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <template v-if="status == null">
                <button @click="sendEmail" class="btn btn-dark">Подтвердить</button>
            </template>
            <template v-else>
                <button disabled class="btn btn-dark">Подтверждён</button>
            </template>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                message: '',
                status: null
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$store.getters.ID).then((resolve) => {
                this.status = resolve.user.email_verified_at;
            })
        },
        methods: {
            sendEmail: function () {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                axios.get('/api/email/confirm', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.message = data.message;
                    })
                    .catch(() => {
                        this.message = '';
                    })
            }
        }
    }
</script>

<style scoped>
    .message-text {
        color: lightcoral;
        font-size: 1rem;
        font-weight: bold;
    }
    .header-text {
        font-size: 1.5rem;
        color: #b4aff1;
    }
</style>
