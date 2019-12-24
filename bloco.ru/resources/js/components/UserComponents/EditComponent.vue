<template>
    <v-row>
        <v-spacer></v-spacer>
        <v-col cols="8">
            <v-row justify="center">
                <p class="display-2 no-route-link--color">РЕДАКТИРОВАНИЕ ПРОФИЛЯ</p>
            </v-row>
            <v-divider></v-divider>
            <form @submit.prevent="updateUser">
                <div class="form-group section--image">
                    <div class="section--image-item">
                        <v-avatar size="7rem" tile>
                            <v-img :src="form.image" alt="#UI">
                            </v-img>
                        </v-avatar>
                    </div>
                    <div class="section--image-item">
                        <input v-model="form.image" type="text" name="image"
                               class="form-control section--input no-route-link--color"
                               :class="{ 'is-invalid': form.errors.has('image') }"
                               placeholder="Изображение профиля"
                        >
                        <has-error :form="form" field="image"></has-error>
                        <span class="subtitle-1 no-route-link--color">
                            Вставьте ссылку на изображение, которое хотите видеть в профиле.
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <input v-model="form.name" type="text" name="name"
                           class="form-control no-route-link--color"
                           :class="{ 'is-invalid': form.errors.has('name') }"
                           placeholder="Настоящее имя">
                    <has-error :form="form" field="name"></has-error>
                    <span class="subtitle-1 no-route-link--color">
                        Укажите ваши имя и фамилию, чтобы другие пользователи смогли узнать, как вас зовут
                    </span>
                </div>

                <div class="form-group">
                    <input v-model="form.specialization" type="text" name="specialization"
                           class="form-control no-route-link--color"
                           :class="{ 'is-invalid': form.errors.has('specialization') }"
                           placeholder="Специализация"
                    >
                    <has-error :form="form" field="specialization"></has-error>
                    <span class="subtitle-1 no-route-link--color">
                        Укажите свою специализацию. Например: Веб разработчик
                    </span>
                </div>

                <div class="form-group">
                    <textarea v-model="form.about" type="text" name="about"
                              class="form-control no-route-link--color"
                              :class="{ 'is-invalid': form.errors.has('about') }"
                              placeholder="О себе">
                    </textarea>
                    <has-error :form="form" field="about"></has-error>
                    <span class="subtitle-1 no-route-link--color">
                        Расскажите о себе. Например:
                        Back-end веб разработчик, проживаю и работаю в Германии,
                        рассказываю о своей работе и как адаптироваться не в родной стране.
                    </span>
                </div>

                <v-btn type="submit" dark outlined color="#50575B">
                    Отредактировать
                </v-btn>
            </form>
        </v-col>
        <v-spacer></v-spacer>
    </v-row>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    name: this.$store.getters.NAME,
                    specialization: this.$store.getters.SPECIALIZATION,
                    about: this.$store.getters.ABOUT,
                    image: this.$store.getters.IMAGE
                })
            }
        },
        methods: {
            updateUser() {
                this.$store.dispatch('UPDATE_USER', { data: this.form, id: this.$route.params.id})
                    .then(() => (this.$router.push({name: 'user', params: { id: this.$route.params.id }})));
            }
        }
    }
</script>

<style scoped>
    .section--image {
        display: block;
    }
    .section--image-item {
        display: inline-block;
    }
    .section--input {
        width: 100%;
    }
</style>
