<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="11" lg="9" xl="6">
            <v-row justify="center" class="mt-2">
                <p class="display-2 no-route-link--color">РЕДАКТИРОВАНИЕ СТАТЬИ</p>
            </v-row>
            <v-col cols=12 class="ma-0 pa-0">
                <v-row justify="center" class="mt-2">
                    <p class="title">{{ form.title }}</p>
                </v-row>
            </v-col>
            <v-divider></v-divider>
            <template v-if="form.author_id == $store.getters.ID">
                <form @submit.prevent="updatePost">
                    <div class="form-group my-0 py-4">
                        <v-col cols="12" class="pa-0">
                            <div class="title mb-1">Текст статьи</div>
                            <editor
                                v-model="form.body" name="body"
                                class="form-control no-route-link--color"
                                :class="{ 'is-invalid': form.errors.has('body') }"
                                api-key="29hv0shfon7y1i3ayspbk71bs3dy13lj3kxesuslq7ll3wfw"
                                :init="{
                                         height: 800,
                                         menubar: false,
                                         plugins: [
                                           'advlist autolink lists link image charmap print preview anchor',
                                           'searchreplace visualblocks code fullscreen',
                                           'insertdatetime media table paste code help wordcount'
                                         ],
                                         toolbar:
                                           'formatselect | bold italic backcolor | \
                                           link image | \
                                           bullist numlist | removeformat | code '
                                       }">
                            </editor>
                            <has-error :form="form" field="body"></has-error>
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
    import Editor from '@tinymce/tinymce-vue';
    import axios from 'axios';

    export default {
        data() {
            return {
                form: new Form({
                    title: '',
                    body: '',
                    author_id: 0
                })
            }
        },
        components: {
            'editor': Editor
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
            axios.get('/api/v1/edit-posts/' + this.$route.params.id).then(({data}) => {
                this.form.title = data.post.title;
                this.form.body = data.post.body;
                this.form.author_id = data.post.author_id;
            });
        }
    };
</script>

<style scoped>
    .btn-form-container {
        display: inline-block;
    }
</style>
