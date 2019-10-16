<template>
    <div id="war_game">
        <div>
            <div>{{ hp1 }} hp</div>
            <div>{{ hp2 }} hp</div>
        </div>
        <div>
            <button v-on:click="randomDamage">Нанести урон</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                max_hp : 10,
                hp1: 10,
                hp2: 10,
                game_over: false
            }
        },

        methods: {
            randomDamage: function() {
                let random_index = Math.floor(Math.random() * 2);
                if (!this.game_over) {
                    random_index === 0 ? --this.hp1 : --this.hp2;
                    if (this.hp1 === 0 || this.hp2 === 0) this.game_over = true;
                } else {
                    this.endGame(this.hp1 === 0 ? 2 : 1);
                }
            },
            endGame: function(index) {
                alert('Игрок #' + index + ' выиграл!')
                this.hp1 = this.hp2 = this.max_hp;
                this.game_over = false;
            }
        }
    }
</script>

<style scoped lang="scss">

</style>
