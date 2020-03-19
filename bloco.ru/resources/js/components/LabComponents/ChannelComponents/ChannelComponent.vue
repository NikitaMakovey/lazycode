<template>
    <div>
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script>
    import { Line } from 'vue-chartjs'

    export default {
        extends: Line,
        props: ['channeldata', 'channelname'],
        data() {
            return {
                chartdata: {
                    labels: this.channeldata,
                    datasets: [
                        {
                            label: this.channelname,
                            backgroundColor: '#f87979',
                            data: this.channeldata
                        }
                    ]
                },
                options: {
                    responsive: true
                }
            }
        },
        mounted () {
            this.renderChart(this.chartdata, this.options);
        }
    }
</script>

<style scoped>

</style>
