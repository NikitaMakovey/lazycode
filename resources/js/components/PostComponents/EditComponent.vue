<template>
    <v-row class="ma-0">
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="11" lg="9" xl="6" class="px-1">
            <v-row justify="center" class="mt-2 mx-0">
                <p class="display-2 no-route-link--color">РЕДАКТИРОВАНИЕ СТАТЬИ</p>
            </v-row>
            <v-col cols=12 class="ma-0 pa-0">
                <v-row justify="center" class="ma-0 px-1">
                    <p class="title ma-0">{{ form.title }}</p>
                </v-row>
            </v-col>
            <v-divider></v-divider>
            <template v-if="form.author_id == $store.getters.ID">
                <form @submit.prevent="updatePost">
                    <div class="form-group my-0 py-4">
                        <v-col cols="12" class="pa-0">
                            <div class="title mb-1">Текст статьи</div>
                            <quill-editor
                                style="background-color: #ffffff"
                                v-model="form.body" :options="editorConfig"
                            ></quill-editor>
                        </v-col>
                    </div>
                    <div>
                        <div class="btn-form-container">
                            <v-btn type="submit" class="route__style" dark color="#50575B">
                                СОХРАНИТЬ ИЗМЕНЕНИЯ
                            </v-btn>
                        </div>
                    </div>
                </form>
            </template>
            <template v-else>
                <v-row justify="center" class="mt-2">
                    <p class="display-2">403 Запрещено</p>
                </v-row>
            </template>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                form: new Form({
                    title: '',
                    body: '',
                    author_id: 0
                }),
                editorData: '',
                editorConfig: {
                    modules: {
                        toolbar: [
                            [{ 'font': [] }],
                            [ 'bold', 'italic', 'underline', 'strike' ],
                            [{ 'size': [] }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'script': 'super' }, { 'script': 'sub' }],
                            [{ 'header': '1' }, { 'header': '2' }, 'blockquote', 'code-block' ],
                            [{ 'list': 'ordered' }, { 'list': 'bullet'}, { 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'align': [] }, 'image', 'clean' ]
                        ]
                    },
                    placeholder: 'Место для твоего пера...',
                    theme: 'snow'
                }
            }
        },
        methods: {
            updatePost() {
                let url = '/api/v1/posts/' + this.$route.params.id;
                let token = this.$store.getters.ACCESS_TOKEN;
                let config = {
                    headers: {
                        Authorization: token
                    }
                };
                this.form.put(url, config)
                    .then(() => { this.$router.push('/') });
            }
        },
        mounted() {
            let token = this.$store.getters.ACCESS_TOKEN;
            let config = {
                headers: {
                    Authorization: token
                }
            };
            axios.get('/api/v1/edit-posts/' + this.$route.params.id, config).then(({data}) => {
                this.form.title = data.post.title;
                this.form.body = data.post.body;
                this.form.author_id = data.post.author_id;
            });
        }
    };
</script>

<style scoped>
    .ma-0 {
        margin: 0 !important;
    }

    @media screen and (max-width: 400px) {
        .display-2 {
            font-size: 1.4rem !important;
            margin: 0 !important;
        }
    }

    @media screen and (min-width: 401px) and (max-width: 599px) {
        .display-2 {
            font-size: 1.7rem !important;
            margin: 0 !important;
        }
    }

    .btn-form-container {
        display: inline-block;
    }
</style>
