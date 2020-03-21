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
                    <div class="form-group col-md-8 col-12 col-sm-10 col-lg-6 col-xl-6 mb-0">
                        <v-avatar
                            color="grey"
                            size="260"
                            tile
                        >
                            <v-img :src="form.image" alt="Фото профиля"></v-img>
                        </v-avatar>
                        <v-col cols="12" class="mx-0 pa-0 mt-1">
                            <div class="filezone">
                                <input
                                    type="file" id="file" ref="file"
                                    multiple v-on:change="handleFile()"
                                    class="form-control" name="file"
                                    :class="{ 'is-invalid': form.errors.has('image') }"
                                />
                                <p>
                                    Перетащите файл сюда <br>или нажмите для поиска
                                </p>
                                <has-error :form="form" field="file"></has-error>
                            </div>
                        </v-col>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark mt-0">Изменить</button>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

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
            handleFile () {
                console.log(this.$refs.file.files);

                let formData = new FormData();
                formData.append('file', this.$refs.file.files[0]);

                let url = '/api/uploads/image';
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token,
                        'Content-Type': 'multipart/form-data'
                    }
                };

                let file__type = this.$refs.file.files[0].type;
                if (file__type === "image/jpeg" || file__type === "image/png") {
                    axios.post(url, formData, config)
                        .then(({data}) => {
                            this.form.image = data.url;
                            console.log('success');
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                } else {
                    this.form.image = '';
                }
            },
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
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 100px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 100px;
        position: relative;
        cursor: pointer;
    }
    .filezone:hover {
        background: #c0c0c0;
    }
    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }

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
