<template>
    <div class="chart-container" style="position: relative">
        <canvas ref="chart"></canvas>
    </div>
</template>

<script>
    import Moment from "moment";
    import Chart from "chart.js";

    export default {
        props: {
            type: {
                type: String,
                required: true,
            },

            data: {
                type: Object,
                required: true,
            },

            triggerUpdate: {
                type: Number,
                default: 0,
            },

            options: {
                type: Object,
                default: function () {
                    return {};
                },
            }
        },

        watch: {
            // Kind of a hackish way to make sure that Vue.js triggers
            // a chart.js update.
            triggerUpdate(trigger) {
                this.chart.update();
            },
        },

        data() {
            return {
                chart: {},
            };
        },

        mounted() {
            this.chart = new Chart(this.$refs.chart, {
                type: this.type,
                data: this.data,
                options: {
                    responsive: true,
                    ...this.options,
                }
            });
        },
    };
</script>
