<template>
    <base-chart type="pie" :data="data" :options="options"></base-chart>
</template>

<script>
    import BaseChart from "./BaseChart.vue";

    export default {
        components: {
            BaseChart,
        },

        props: {
            completed: {
                type: Number,
                required: true,
            },

            missed: {
                type: Number,
                required: true,
            },

            graph_only: {
                default:true,
            },
            colors:{
                required:false,
                default:function () {return ['#28a745','#dc3545',]},
            }   

        },

        data() {
            return {
            };
        },

        computed:{
            total: function () {
                return this.completed+this.missed
            },

            completed_adjusted: function () {
                if(this.total<10){
                    return 10-this.missed_adjusted
                }
                return this.completed
            },

            missed_adjusted: function () {
                if(this.missed==0){
                    return 0
                }else{
                    return this.missed-1
                }
            },

            data: function() {
                return {
                        labels: ["Completed", "Incomplete"],
                        datasets: [{
                            data: [
                                this.completed_adjusted,
                                this.missed_adjusted,
                            ],
                            backgroundColor: this.colors,
                        }],
                    
                }
            },
            options: function() {
                return {
                        legend: {
                            display: !this.graph_only
                        },
                        animation: false,
                }
            },
        }


    }
</script>
