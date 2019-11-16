<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="createPost">
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
                            initialValue="<p>Текст Вашей статьи</p>"
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
                    <button type="submit" class="btn btn-primary">Запостить</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue';

    export default {
        name: "CreatePostPage",
        data() {
            return {
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
            createPost() {
                this.form.post('http://localhost:8000/api/posts')
            }
        }
    };
</script>

<style scoped>

</style>
