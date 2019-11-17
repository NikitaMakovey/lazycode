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
            </div>
        </div>
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue';

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
                let patchRoute = "/api/posts/" + this.post_id;
                this.form.patch(patchRoute, this.form).then(() => (this.$router.push({path: '/'})));
            }
        },
        mounted() {
            let id = this.$route.params.id;
            this.post_id = id;
            let getRoute = "/api/posts/" + id;
            axios.get(getRoute).then(function ({data}) {
                this.form.title = data.title;
                this.form.category_id = data.title;
                this.form.author_id = data.author_id;
                this.form.body = data.body;
            });
        }
    };
</script>

<style scoped>

</style>
