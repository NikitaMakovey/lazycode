<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Таблица Posts</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addModal">
                                Добавить <i class="fas fa-list-alt fa-fw"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Category ID</th>
                                <th>Author ID</th>
                                <th>Body</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="post in posts" :key="post.id">
                                <td>{{ post.id }}</td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.image }}</td>
                                <td>{{ post.category_id }}</td>
                                <td>{{ post.author_id }}</td>
                                <td>{{ post.body }}</td>
                                <td>{{ post.created_at }}</td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    |
                                    <a href="#">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Добавить пост</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createPost">
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea v-model="form.title" type="text" name="title"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('title') }"
                                       placeholder="Title">
                                </textarea>
                                <has-error :form="form" field="title"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.category_id" type="number" name="category_id"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }"
                                       placeholder="Category ID">
                                <has-error :form="form" field="category_id"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.author_id" type="number" name="author_id"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('author_id') }"
                                       placeholder="Author ID">
                                <has-error :form="form" field="author_id"></has-error>
                            </div>

                            <div class="form-group">
                                <textarea v-model="form.body" type="text" name="body"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('body') }"
                                       placeholder="Body">
                                </textarea>
                                <has-error :form="form" field="body"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts : {},
                form: new Form({
                    title: '',
                    category_id: '',
                    author_id: '',
                    body: ''
                })
            }
        },
        methods : {
            loadPosts() {
                axios.get("api/posts").then(({data}) => (this.posts = data))
            },
            createPost() {
                this.form.post('api/posts')
            }
        },
        created() {
            this.loadPosts();
        }
    }
</script>
