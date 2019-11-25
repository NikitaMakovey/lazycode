<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form @submit.prevent="updateUser">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }"
                               placeholder="Ваше настоящее имя">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.specialization" type="text" name="specialization"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('specialization') }"
                               placeholder="Ваша специализация (например, Администратор баз данных)">
                        <has-error :form="form" field="specialization"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.image" type="text" name="image"
                               class="form-control" :class="{ 'is-invalid': form.errors.has('image') }"
                               placeholder="http://your_image.jpg">
                        <has-error :form="form" field="image"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea v-model="form.about" type="text" name="about"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('about') }"
                                  placeholder="О себе">
                        </textarea>
                        <has-error :form="form" field="about"></has-error>
                    </div>
                    <div class="form-group">

                    </div>
                    <button type="submit" class="btn btn-primary">Отредактировать</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditUserPage",
        data() {
            return {
                user : [],
                user_id : null,
                form: new Form({
                    name: '',
                    specialization: '',
                    about: '',
                    image: ''
                })
            }
        },
        methods: {
            updateUser() {
                let patchRoute = "/api/lazycode/users/" + this.user_id;
                this.form.patch(patchRoute, this.form)
                    .then(() => (this.$router.push({name: 'user', params: { id: this.user_id }})));
            }
        },
        mounted() {
            let id = this.$route.params.id;
            this.user_id = id;
            let getRoute = "/api/lazycode/users/" + id;
            axios.get(getRoute).then(({data}) => (this.user = data));
        }
    }
</script>

<style scoped>

</style>
