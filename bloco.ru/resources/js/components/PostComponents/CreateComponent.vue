<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" sm="11" md="11" lg="9" xl="6">
            <v-row justify="center">
                <p class="display-2 no-route-link--color">СОЗДАНИЕ СТАТЬИ</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="createPost" @cancel.prevent="sendToDraft">
                <div class="form-group">
                    <label for="selectTitleCreatePost">Заголовок статьи</label>
                    <input v-model="form.title" type="text" name="title"
                           class="form-control title no-route-link--color"
                           :class="{ 'is-invalid': form.errors.has('title') }"
                           id="selectTitleCreatePost"
                           placeholder="Здесь вам необходимо написать заголовок Вашей статьи."
                    >
                    <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                    <label for="selectBodyCreatePost">Категория статьи</label>
                    <v-select
                        v-model="category"
                        :items="CATEGORIES"
                        item-text="name"
                        item-value="id"
                        return-object
                        single-line
                        placeholder="Выберите категорию"
                        :class="{ 'is-invalid': form.errors.has('category_id') }"
                        name="category_id"
                    ></v-select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                    
                </div>
                <div class="form-group">
                    <label for="selectBodyCreatePost">Текст статьи</label>
                    <editor
                        v-model="form.body" name="body" id="selectBodyCreatePost"
                        class="form-control no-route-link--color"
                        :class="{ 'is-invalid': form.errors.has('body') }"
                        api-key="29hv0shfon7y1i3ayspbk71bs3dy13lj3kxesuslq7ll3wfw"
                        initialValue="<p>Melted chickpeas can be made cored by covering with peppermint tea.</p>"
                        :init="{
                                 height: 1000,
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
                </div>
                <div>
                    <div class="btn-form-container">
                        <v-btn type="submit" class="route__style" dark color="#50575B">
                            ОТПРАВИТЬ НА ПРОВЕРКУ
                        </v-btn>
                    </div>
                    <div class="btn-form-container">
                        <v-btn type="cancel" class="route__style" dark outlined color="#50575B">
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
    import Editor from '@tinymce/tinymce-vue';
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                category: { id: 0, name: 'Выберите категорию', slug: 'vibirite', cat_count: 0 },
                form: new Form({
                    title: '',
                    category_id: '',
                    image: '',
                    body: ''
                })
            }
        },
        components: {
            'editor': Editor
        },
        methods: {
            createPost() {
                if (this.category) {
                    let categories_ = this.CATEGORIES;
                    this.form.category_id = categories_.find(x => x.name === this.category).id;
                    this.$store.dispatch('SET_POST', this.form)
                        .then(() => (this.$router.push({path: '/'})));
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
