<template>
    <div>
        <div>
            <p class="header-text">Информация о Вас</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendBio">
                <div class="form-row">
                    <div class="form-group col-12">
                        <label for="specialization">Специализация</label>
                        <input
                            v-model="form.specialization" name="specialization"
                            type="text" class="form-control"
                            id="specialization" placeholder="Специализация"
                            :class="{ 'is-invalid': form.errors.has('specialization') }"
                        >
                        <has-error :form="form" field="specialization"></has-error>
                    </div>
                    <div class="form-group col-12">
                        <label for="about">Био</label>
                        <textarea
                            v-model="form.about" name="about"
                            type="text" class="form-control bio-field"
                            id="about" placeholder="Расскажите о себе"
                            :class="{ 'is-invalid': form.errors.has('about') }"
                        >
                        </textarea>
                        <has-error :form="form" field="about"></has-error>
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
                    specialization: '',
                    about: ''
                })
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$store.getters.ID).then((resolve) => {
                this.form.specialization = resolve.user.specialization == null ? '' : resolve.user.specialization;
                this.form.about = resolve.user.about == null ? '' : resolve.user.about;
            })
        },
        methods: {
            sendBio: function () {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/edit/bio', config)
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
    .bio-field {
        min-height: 10rem;
    }
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
