<template>
    <div>
        <v-system-bar window dark>
            <v-spacer></v-spacer>
            <v-icon>mdi-minus</v-icon>
            <v-icon>mdi-checkbox-blank-outline</v-icon>
            <v-icon>mdi-close</v-icon>
        </v-system-bar>
        <v-system-bar window light>
            <v-menu bottom offset-y>
                <template v-slot:activator="{ on }">
                    <span
                        v-on="on"
                    >
                        Файл
                    </span>
                </template>
                <v-list class="pa-0">
                    <v-list-item
                        v-for="(item, index) in file_items"
                        :key="index"
                        @click=""
                    >
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
            <span>Моделирование</span>
            <span>Фильтрация</span>
            <span>Анализ</span>
            <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                <template v-slot:activator="{ on }">
                    <span v-on="on">Настройки</span>
                </template>
                <v-card>
                    <v-toolbar dark color="black">
                        <v-btn icon dark @click="dialog = false">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                        <v-toolbar-title>Настройки</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn dark text @click="dialog = false">Сохранить</v-btn>
                        </v-toolbar-items>
                    </v-toolbar>
                    <v-list three-line subheader>
                        <v-subheader>Настройки изображения</v-subheader>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>Что-то настроить</v-list-item-title>
                                <v-list-item-subtitle>Set the content filtering level to restrict apps that can be downloaded</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>Что-то ещё настроить</v-list-item-title>
                                <v-list-item-subtitle>Require password for purchase or use password to restrict purchase</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list three-line subheader>
                        <v-subheader>Общие настройки</v-subheader>
                        <v-list-item>
                            <v-list-item-action>
                                <v-checkbox v-model="notifications"></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Уведомления</v-list-item-title>
                                <v-list-item-subtitle>Уведомлять me about updates to apps or games that I downloaded</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-action>
                                <v-checkbox v-model="sound"></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Звук</v-list-item-title>
                                <v-list-item-subtitle>Auto-update apps at any time. Data charges may apply</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-action>
                                <v-checkbox v-model="widgets"></v-checkbox>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Автомотическое добавление окон</v-list-item-title>
                                <v-list-item-subtitle>Automatically add home screen widgets</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-dialog>
            <span
                @click.stop="dialog_about = true"
            >
                Справка
            </span>
            <v-dialog
                v-model="dialog_about"
                max-width="290"
            >
                <v-card>
                    <v-card-title class="headline">Авторы лаборатории</v-card-title>

                    <v-card-text>
                        <p class="mb-1">Маковей Никита</p>
                        <p class="mb-1">Маковей Людмила</p>
                        <p class="mb-1">Лоншакова Анастасия</p>
                        <p class="mb-1">Ващенко Светлана</p>
                        <p class="mb-1">Гасанова Сабина</p>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="dialog_about = false"
                        >
                            ОК
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <v-spacer></v-spacer>
        </v-system-bar>
    </div>
</template>

<script>
    export default {
        name: "ComputerGraphicsComponent",
        data() {
            return {
                file_items: [
                    { title: 'Новый файл' },
                    { title: 'Открыть' },
                    { title: 'Сохранить' },
                    { title: 'Сохранить как' }
                ],
                dialog_about: false,
                dialog: false,
                notifications: false,
                sound: true,
                widgets: false,
            }
        }
    }
</script>

<style scoped>
    span {
        margin-left: 1rem;
        margin-right: 1rem;
    }
</style>
