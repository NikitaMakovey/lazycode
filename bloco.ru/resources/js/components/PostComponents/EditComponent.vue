<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10">
            <v-row justify="center">
                <p class="display-2 no-route-link--color">РЕДАКТИРОВАНИЕ ПОСТА</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="updatePost">
                <div class="form-group">
                    <label for="selectTitleEditPost">Заголовок статьи</label>
                    <input v-model="form.title" type="text" name="title"
                           class="form-control title no-route-link--color"
                           :class="{ 'is-invalid': form.errors.has('title') }"
                           id="selectTitleEditPost"
                    >
                    <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                    <label for="selectCategoryEditPost">Категория поста</label>
                    <select v-model="category" class="form-control subtitle-1 no-route-link--color"
                            id="selectCategoryEditPost"
                    >
                        <option class="subtitle-1 no-route-link--color" v-for="category_ in CATEGORIES"
                                :value="category_.name" :key="category_.id"
                        >
                            {{ category_.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectBodyEditPost">Текст статьи</label>
                    <editor
                        v-model="form.body" name="body" id="selectBodyEditPost"
                        class="form-control no-route-link--color"
                        :class="{ 'is-invalid': form.errors.has('body') }"
                        api-key="29hv0shfon7y1i3ayspbk71bs3dy13lj3kxesuslq7ll3wfw"
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
                <v-btn type="submit" dark outlined color="#50575B">
                    Отредактировать
                </v-btn>
                <v-btn @click="deletePost" dark outlined color="#50575B">
                    Уничтожить безвозвратно
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
                category: localStorage.getItem('P_CATEGORY'),
                form: new Form({
                    title: localStorage.getItem('P_TITLE'),
                    category_id: localStorage.getItem('P_CATEGORY_ID'),
                    author_id: this.$store.getters.USER_ID,
                    body: localStorage.getItem('P_BODY')
                })
            }
        },
        components: {
            'editor': Editor
        },
        methods: {
            updatePost() {
                let categories_ = this.CATEGORIES;
                this.form.category_id = categories_.find(x => x.name === this.category).id;
                this.$store.dispatch('UPDATE_POST', {data: this.form, id: this.$route.params.id })
                    .then(() => (this.$router.push({ path: '/' })));
            },
            deletePost() {
                this.$store.dispatch('DELETE_POST', this.$route.params.id)
                    .then(() => (this.$router.push({ path: '/' })));
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
