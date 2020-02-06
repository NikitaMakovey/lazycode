<template>
    <div>
        <div>
            <p class="header-text">Ваша фотография</p>
        </div>
        <div>
            <p class="message-text">{{ message }}</p>
        </div>
        <div>
            <form @submit.prevent="sendPhoto">
                <div class="form-row">
                    <div class="form-group col-md-8 col-12 col-sm-10 col-lg-6 col-xl-6">
                        <v-avatar
                            color="grey"
                            size="260"
                            tile
                        >
                            <v-img :src="form.image" alt="Фото профиля"></v-img>
                        </v-avatar>
                        <v-col cols="12" class="mx-0 pa-0">
                            <label for="image" class="link-field">
                                URL фотографии профиля
                            </label>
                            <input
                                v-model="form.image" name="image"
                                type="text" class="form-control"
                                id="image" placeholder="URL фотографии профиля"
                                :class="{ 'is-invalid': form.errors.has('image') }"
                            >
                            <has-error :form="form" field="image"></has-error>
                        </v-col>
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
                    image: ''
                })
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$store.getters.ID).then((resolve) => {
                this.form.image = resolve.user.image;
            })
        },
        methods: {
            sendPhoto: function () {
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put('/api/edit/image', config)
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
    @media screen and (max-width: 599px) {

    }
    /* --- */

    @media screen and (min-width: 600px) and (max-width: 959px) {

    }
    /* --- */

    @media screen and (min-width: 960px) and (max-width: 1263px) {

    }
    /* --- */

    @media screen and (min-width: 1264px) {

    }
    /* --- */

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
