<template>
    <div>
        <div>
            <p class="header-text">Основная информация</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendMain">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Имя</label>
                        <input
                            v-model="form.name" name="name"
                            type="text" class="form-control"
                            id="name" placeholder="Имя"
                            :class="{ 'is-invalid': form.errors.has('name') }"
                        >
                        <has-error :form="form" field="name"></has-error>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Никнейм</label>
                        <input
                            v-model="form.username" name="username"
                            type="text" class="form-control"
                            id="username" placeholder="Отчество"
                            :class="{ 'is-invalid': form.errors.has('username') }"
                        >
                        <has-error :form="form" field="username"></has-error>
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
                    name: '',
                    username: ''
                })
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$store.getters.ID).then((resolve) => {
                this.form.name = resolve.user.name;
                this.form.username = resolve.user.username;
            })
        },
        methods: {
            sendMain: function () {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/edit/main', config)
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
