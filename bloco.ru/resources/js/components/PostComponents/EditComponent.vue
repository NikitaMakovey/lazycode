<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="10">
            <v-row justify="center">
                <p class="display-2">РЕДАКТИРОВАНИЕ ПОСТА</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="updatePost">
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
                    >
                    <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                    <editor
                        v-model="form.body" name="body"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('body') }"
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
                form: new Form({
                    title: this.$store.getters.POSTS[0].post_title,
                    category_id: this.$store.getters.POSTS[0].category_id,
                    author_id: this.$store.getters.USER_ID,
                    body: this.$store.getters.POSTS[0].post_body
                })
            }
        },
        components: {
            'editor': Editor
        },
        methods: {
            updatePost() {
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
            ...mapGetters(['CATEGORIES']),
            /**
             * @return {string}
             */
            ACTIVE_MODE() { return this.$store.state.categories[this.$store.getters.POSTS[0].category_id].name }
        }
    };
</script>

<style scoped>

</style>
