<template>
    <div>
        <div>
            <p class="header-text">Ваш E-mail</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendEmail">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="email">E-mail</label>
                        <input
                            v-model="form.email" name="email"
                            type="email" class="form-control"
                            id="email" placeholder="E-mail"
                            :class="{ 'is-invalid': form.errors.has('email') }"
                        >
                        <has-error :form="form" field="email"></has-error>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark">Изменить</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                form: new Form({
                    email: ''
                })
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$store.getters.ID).then((resolve) => {
                this.form.email = resolve.user.email;
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
                this.form.put('/api/edit/email', config)
                    .then(({data}) => {
                        if (data.message === -1) {
                            this.$store.dispatch('LOGOUT_USER')
                                .then(() => {
                                    this.$router.push({ name: 'auth.login' });
                                });
                        }
                        this.$store.dispatch('UPDATE_USER', data.user);
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
        font-size: 1.4rem;
        color: #b4aff1;
    }
</style>
