<template>
    <div>
        <v-system-bar window dark>
            <v-spacer></v-spacer>
            <v-icon>mdi-minus</v-icon>
            <v-icon>mdi-checkbox-blank-outline</v-icon>
            <router-link to="/">
                <v-icon>mdi-close</v-icon>
            </router-link>
        </v-system-bar>
        <v-system-bar window light style="overflow-x: scroll">
            <v-menu bottom offset-y>
                <template v-slot:activator="{ on }">
                    <span
                        v-on="on"
                    >
                        Файл
                    </span>
                </template>
                <v-list class="pa-0">
                    <v-list-item>
                        <v-list-item-title>
                            <input type="file" @change="loadFile">
                        </v-list-item-title>
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
                max-width="600"
            >
                <v-card>
                    <v-card-title class="headline" style="font-size: 1rem !important;">
                        Система визуализации многоканальных сигналов
                    </v-card-title>
                    <v-card-title class="headline" style="color: #6574cd">
                        Группа: Б8118-01.03.02систпро
                    </v-card-title>
                    <v-card-title class="headline" style="color: #a9a9a9">
                        Состав команды:
                    </v-card-title>

                    <v-card-text>
                        <p class="mb-1">Маковей Никита</p>
                        <p class="mb-1">Романенкова Людмила</p>
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
        <v-col cols="12">
            <v-row>
                <v-col cols="12">
                    <template v-if="this.$store.getters.CHANNELS !== null">
                        <v-col cols="12">
                            <v-subheader>Каналы</v-subheader>
                            <v-row v-for="(data, index) in this.$store.getters.CHANNELS" :key="index">
                                <channel-component :channeldata="data" :channelname="'NP' + index"></channel-component>
                            </v-row>
                        </v-col>
                    </template>
                </v-col>
            </v-row>
        </v-col>
    </div>
</template>

<script>
    import ChannelComponent from "./ChannelComponents/ChannelComponent";

    export default {
        name: "ComputerGraphicsComponent",
        components: {
            'channel-component' : ChannelComponent
        },
        data() {
            return {
                dialog_about: false,
                dialog: false,
                notifications: false,
                sound: true,
                widgets: false,
            }
        },
        methods: {
            loadFile: function (e) {
                const file = e.target.files[0];

                let file__type = file.type;
                let file__name = file.name;

                if (file__type === "text/plain") {
                    this.readFile(file);
                }
            },
            readFile: function (file) {
                let CHANNELS = null;
                const reader = new FileReader();
                const store = this.$store;
                const vm = this;
                reader.onload = function() {
                    let cnt = 0;
                    const DATA = reader.result.split("\n").map(function (d) {
                        let delta = d.split(" ");
                        if (cnt < 12) {
                            if (cnt === 1) {
                                let count_channels = Number(delta[0]);
                                if (count_channels > 0 && count_channels !== null) {
                                    localStorage.setItem('FILE__COUNT_CHANNELS', count_channels);
                                    CHANNELS = new Array(localStorage.getItem('FILE__COUNT_CHANNELS'));
                                    for (let i = 0; i < localStorage.getItem('FILE__COUNT_CHANNELS'); i++) {
                                        CHANNELS[i] = new Array(0);
                                    }
                                }
                            }
                            if (cnt === 11) {
                                const CHANNELS_NAMES = d.split(";");
                            }
                        } else {
                            for (let i = 0; i < localStorage.getItem('FILE__COUNT_CHANNELS'); i++) {
                                CHANNELS[i].push(Number(delta[i]));
                            }
                        }
                        cnt++;
                    });
                    store.dispatch('UPDATE_CHANNELS', CHANNELS).then(() => {
                        vm.drawChannels();
                    })
                };
                reader.readAsText(file);
            },
            drawChannels: function() {
                console.log(this.$store.getters.CHANNELS);
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
