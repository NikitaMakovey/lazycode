<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10">
            <v-row justify="center">
                <p class="display-2 no-route-link--color">СОЗДАНИЕ ПОСТА</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="createPost">
                <div class="form-group">
                    <label for="selectTitleCreatePost">Заголовок статьи</label>
                    <input v-model="form.title" type="text" name="title"
                           class="form-control title no-route-link--color"
                           :class="{ 'is-invalid': form.errors.has('title') }"
                           id="selectTitleCreatePost" placeholder="The addled anchor awkwardly endures the seashell."
                    >
                    <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                    <label for="selectCategoryCreatePost">Категория поста</label>
                    <select v-model="category" class="form-control subtitle-1 no-route-link--color"
                            id="selectCategoryCreatePost"
                    >
                        <option class="subtitle-1 no-route-link--color"
                                v-for="category_ in CATEGORIES"
                                :value="category_.name" :key="category_.id"
                        >
                            {{ category_.name }}
                        </option>
                    </select>
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
                <v-btn type="submit" class="route__style" dark outlined color="#50575B">
                    Запостить
                </v-btn>
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
                category: null,
                form: new Form({
                    title: '',
                    category_id: '',
                    author_id: this.$store.getters.USER_ID,
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

</style>
