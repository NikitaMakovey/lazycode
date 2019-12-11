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
    import {mapGetters} from 'vuex';

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
                this.$store.dispatch('UPDATE_USER', { data: this.form, id: this.$route.params.id})
                    .then(() => (this.$router.push({name: 'user', params: { id: this.user_id }})));
            }
        },
        mounted() {
            this.$store.dispatch('GET_USER', this.$route.params.id);
            this.user_id = this.$route.params.id;
        },
        computed: {
            ...mapGetters(['USERS'])
        }
    }
</script>

<style scoped>

</style>
