<template>
    <v-row class="ma-0">
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="11" lg="9" xl="6" class="px-1">
            <v-row justify="center" class="mt-2 mx-0">
                <p class="display-2 no-route-link--color">СОЗДАНИЕ СТАТЬИ</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="createPost">
                <div class="form-group ma-0">
                    <v-row class="mx-0">
                        <v-col cols="12" sm="12" md="7" lg="7" xl="7" class="px-0 res__pr">
                            <div class="title mb-1">Заголовок статьи</div>
                            <textarea v-model="form.title" type="text" name="title"
                                   class="form-control title no-route-link--color"
                                   :class="{ 'is-invalid': form.errors.has('title') }"
                                   placeholder="Тут будет располагаться заголовок Вашей статьи."
                            >
                            </textarea>
                            <has-error :form="form" field="title"></has-error>
                        </v-col>
                        <v-col cols="12" sm="12" md="5" lg="5" xl="5" class="px-0 res__pl">
                            <div class="title mb-1">Категория статьи</div>
                            <v-select
                                solo
                                v-model="category"
                                :items="CATEGORIES"
                                item-text="name"
                                item-value="id"
                                return-object
                                single-line
                                placeholder="Выберите категорию"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('category_id') }"
                                name="category_id"
                            ></v-select>
                            <has-error :form="form" field="category_id"></has-error>
                        </v-col>
                    </v-row>
                </div>
                <div class="form-group ma-0">
                    <v-row class="mx-0 res__row">
                        <v-col cols="12" sm="12" md="7" lg="7" xl="7" class="px-0 res__pr">
                            <div class="title mb-1">Изображение статьи</div>
                            <template v-if="form.image">
                                <div class="subheading">Так будет выглядеть ваше изображение:</div>
                                <div class="card-image-container mb-1">
                                    <img
                                        :src="form.image"
                                        alt="#image" class="preview card-img-top"
                                        ref="image_preview"
                                    />
                                </div>
                            </template>

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
                        <v-col cols="12" sm="12" md="5" lg="5" xl="5" class="px-0 res__pl res__container tags__display-md">
                            <div class="title mb-1">Теги</div>
                            <div class="subheading mb-1">Примеры: ethereum, c++, postgres и тд.</div>
                            <v-combobox
                                v-model="form.tags"
                                :items="form.tags"
                                class="form-control res__combobox"
                                :class="{ 'is-invalid': form.errors.has('tags') }"
                                chips
                                clearable
                                label="Напиши тег и нажми Далее (Enter)"
                                multiple
                                solo
                            >
                                <template v-slot:selection="{ attrs, item, select, selected }">
                                    <v-chip
                                        v-bind="attrs"
                                        :input-value="selected"
                                        close
                                        @click="select"
                                        @click:close="remove(item)"
                                    >
                                        <strong>{{ item }}</strong>&nbsp;
                                    </v-chip>
                                </template>
                            </v-combobox>
                            <has-error :form="form" field="tags"></has-error>
                        </v-col>
                    </v-row>
                </div>
                <div class="form-group my-0 py-4">
                    <v-col cols="12" class="pa-0">
                        <div class="title mb-1">Текст статьи</div>
                        <quill-editor
                            style="background-color: #ffffff"
                            v-model="form.body" :options="editorConfig"
                        ></quill-editor>
                    </v-col>
                </div>
                <div class="form-group my-0 tags__display-xs">
                    <v-col cols="12" sm="12" md="5" lg="5" xl="5" class="px-0 res__pl res__container">
                        <div class="title mb-1">Теги</div>
                        <div class="subheading mb-1">Примеры: ethereum, c++, postgres и тд.</div>
                        <v-combobox
                            v-model="form.tags"
                            :items="form.tags"
                            class="form-control res__combobox"
                            :class="{ 'is-invalid': form.errors.has('tags') }"
                            chips
                            clearable
                            label="Напиши тег и нажми Далее (Enter)"
                            multiple
                            solo
                        >
                            <template v-slot:selection="{ attrs, item, select, selected }">
                                <v-chip
                                    v-bind="attrs"
                                    :input-value="selected"
                                    close
                                    @click="select"
                                    @click:close="remove(item)"
                                >
                                    <strong>{{ item }}</strong>&nbsp;
                                </v-chip>
                            </template>
                        </v-combobox>
                        <has-error :form="form" field="tags"></has-error>
                    </v-col>
                </div>
                <div>
                    <div class="btn-form-container">
                        <v-btn type="submit" class="route__style" dark color="#50575B">
                            ОТПРАВИТЬ НА ПРОВЕРКУ
                        </v-btn>
                    </div>
                    <div class="btn-form-container">
                        <v-btn @click="sendToDraft" class="route__style" dark outlined color="#50575B">
                            В ЧЕРНОВИК
                        </v-btn>
                    </div>
                </div>
            </form>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import {mapGetters} from 'vuex';
    import axios from 'axios';

    export default {
        data() {
            return {
                category: { id: 0, name: 'Выберите категорию' },
                form: new Form({
                    title: '',
                    category_id: '',
                    image: '',
                    body: '',
                    tags: []
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
            remove (item) {
                this.form.tags.splice(this.form.tags.indexOf(item), 1);
                this.form.tags = [...this.form.tags];
            },
            createPost () {
                if (this.category.id !== 0) {
                    this.form.category_id = this.category.id;
                    let url = '/api/v1/posts';
                    let token = this.$store.getters.ACCESS_TOKEN;
                    let config = {
                        headers: {
                            Authorization: token
                        }
                    };
                    this.form.post(url, config)
                        .then(() => { this.$router.push('/') });
                } else {
                    this.form.errors.set('category_id', 'Не выбрана категория');
                }
            },
            sendToDraft () {
                if (this.category.id !== 0) {
                    this.form.category_id = this.category.id;
                    let url = '/api/v1/draft';
                    let token = this.$store.getters.ACCESS_TOKEN;
                    let config = {
                        headers: {
                            Authorization: token
                        }
                    };
                    this.form.post(url, config)
                        .then(() => {
                            this.$router.push('/')
                        });
                } else {
                    this.form.errors.set('category_id', 'Не выбрана категория');
                }
            }
        },
        mounted() {
            this.$store.dispatch('GET_CATEGORIES');
        },
        computed: {
            ...mapGetters(['CATEGORIES'])
        }
    };
</script>

<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
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

    .res__row {
        min-height: auto;
    }
    .res__container {
        min-height: auto;
        height: auto;
    }
    .res__combobox {
        height: auto;
    }

    @media screen and (max-width: 599px) {
        .display-2 {
            font-size: 1.7rem !important;
            margin: 0 !important;
        }
    }

    @media screen and (max-width: 959px) {
        .tags__display-xs {
            display: block !important;
        }
        .tags__display-md {
            display: none !important;
        }
    }

    @media screen and (min-width: 960px) {
        .tags__display-xs {
            display: none !important;
        }
        .tags__display-md {
            display: block !important;
        }
    }

    @media screen and (min-width: 960px) {
        .tags__display-xs {
            height: auto;
        }
        .res__pr {
            padding-right: 1rem !important;
        }
        .res__pl {
            padding-left: 1rem !important;
        }
    }
    /* --- */
    .card-image-container {
        height: auto !important;
        max-height: 320px;
        overflow: hidden;
        width: 100%;
        justify-content: center;
        align-items: center;
        border-bottom: 1px solid #E0C3FC;
        background-color: #8EC5FC;
        background-image: linear-gradient(62deg, #8EC5FC 0%, #E0C3FC 100%);
    }
    img {
        height: auto;
        width: 100%;
    }
    .btn-form-container {
        display: inline-block;
    }
</style>
