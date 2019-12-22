<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10">
            <v-row justify="center">
                <p class="display-2">СОЗДАНИЕ ПОСТА</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="createPost">
                <div class="form-group">
                        <input v-model="form.title" type="text" name="title"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('title') }"
                               placeholder="Заголовок статьи"
                        >
                    <has-error :form="form" field="title"></has-error>
                </div>
                <div class="form-group">
                    <input v-model="form.category_id" type="number" name="category_id"
                           class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }"
                           placeholder="Категория">
                    <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                    <editor
                        v-model="form.body" name="body"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('body') }"
                        api-key="29hv0shfon7y1i3ayspbk71bs3dy13lj3kxesuslq7ll3wfw"
                        initialValue="<p>Текст статьи</p>"
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
                this.$store.dispatch('SET_POST', this.form)
                    .then(() => (this.$router.push({path: '/'})));
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
