<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="updatePost">
                    <div class="form-group">
                        <textarea v-model="form.title" type="text" name="title"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('title') }"
                                  placeholder="Напишите здесь заголовок">
                        </textarea>
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
                            initialValue="1"
                            :init="{
                                 height: 500,
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
                    <button type="submit" class="btn btn-primary">Отредактировать</button>
                </form>
                <button @click="deletePost" class="btn btn-danger">Уничтожить безвозвратно</button>
            </div>
        </div>
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue';
    import {mapGetters} from 'vuex';

    export default {
        name: "EditPostPage",
        data() {
            return {
                post_id : null,
                form: new Form({
                    title: '',
                    category_id: '',
                    author_id: 1,
                    body: ''
                })
            }
        },
        components: {
            'editor': Editor
        },
        methods: {
            updatePost() {
                this.$store.dispatch('UPDATE_POST', {data: this.form, id: this.post_id})
                .then(() => (this.$router.push({ path: '/' })));
            },
            deletePost() {
                //wtf?
                this.$store.dispatch('DELETE_POST', this.post_id)
                .then(() => (this.$router.push({ path: '/' })));
            }
        },
        mounted() {
            this.$store.dispatch('GET_POST', this.$route.params.id);
            this.post_id = this.$route.params.id;
        },
        computed: {
            ...mapGetters(['POSTS'])
            // TODO: POSTS[0] into this.form
        }
    };
</script>

<style scoped>

</style>
