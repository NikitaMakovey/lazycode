<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="11" lg="9" xl="6">
            <v-row justify="center" class="mt-2">
                <p class="display-2 no-route-link--color">СОЗДАНИЕ СТАТЬИ</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="createPost">
                <div class="form-group ma-0">
                    <v-row>
                        <v-col cols="7">
                            <div class="title mb-1">Заголовок статьи</div>
                            <textarea v-model="form.title" type="text" name="title"
                                   class="form-control title no-route-link--color"
                                   :class="{ 'is-invalid': form.errors.has('title') }"
                                   placeholder="Тут будет располагаться заголовок Вашей статьи."
                            >
                            </textarea>
                            <has-error :form="form" field="title"></has-error>
                        </v-col>
                        <v-col cols="5">
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
                    <v-row>
                        <v-col cols="7">
                            <div class="title mb-1">Изображение статьи</div>
                            <div class="subheading">Так будет выглядеть ваше изображение:</div>
                            <v-img
                                :src="form.image === '' ?
                            'https://media.sproutsocial.com/uploads/2017/02/10x-featured-social-media-image-size.png' :
                            form.image"
                                aspect-ratio="1.6" contain></v-img>
                            <input v-model="form.image" type="text" name="image"
                                   class="form-control title no-route-link--color"
                                   :class="{ 'is-invalid': form.errors.has('image') }"
                                   placeholder="Здесь вам необходимо написать URL изображения."
                            >
                            <has-error :form="form" field="image"></has-error>
                        </v-col>
                        <v-col cols="5">
                            <div class="title mb-1">Теги</div>
                            <div class="subheading mb-1">Примеры: ethereum, c++, postgres и тд.</div>
                            <v-combobox
                                v-model="form.tags"
                                :items="form.tags"
                                class="form-control"
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
                        <editor
                            v-model="form.body" name="body"
                            class="form-control no-route-link--color"
                            :class="{ 'is-invalid': form.errors.has('body') }"
                            api-key="29hv0shfon7y1i3ayspbk71bs3dy13lj3kxesuslq7ll3wfw"
                            :init="{
                                     height: 600,
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
                            ОТПРАВИТЬ НА ПРОВЕРКУ
                        </v-btn>
                    </div>
                </div>
            </form>
            <div class="mt-1">
                <div class="btn-form-container">
                    <v-btn type="cancel" @click="sendToDraft" class="route__style" dark outlined color="#50575B">
                        В ЧЕРНОВИК
                    </v-btn>
                </div>
            </div>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue';
    import {mapGetters} from 'vuex';

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
                })
            }
        },
        components: {
            'editor': Editor
        },
        methods: {
            remove (item) {
                this.form.tags.splice(this.form.tags.indexOf(item), 1);
                this.form.tags = [...this.form.tags];
            },
            createPost() {
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
            sendToDraft() {
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
    .btn-form-container {
        display: inline-block;
    }
</style>
