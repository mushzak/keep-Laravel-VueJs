<template>
    <base-chart type="line" :data="data" :options="options"></base-chart>
</template>

<script>
    import BaseChart from "./BaseChart.vue";
    import moment from "moment";

    export default {
        components: {
            BaseChart,
        },

        data() {
            return {
                data:{ 
                    labels:['2017QT1','2017QT2', '2017QT3', '2017QT4','218QT1'],
                    datasets:[  
                        {
                            label:"Average Feedback Ranking",
                            data:[       
                                Math.random()*(8)+1,
                                Math.random()*(6)+2,
                                Math.random()*(6)+3,
                                Math.random()*(5)+5,
                                Math.random()*(2)+7,
                                
                            ],
                            backgroundColor:[
                            "rgba(128, 191,142, 1)",
                                                   
                            ],

                        },
                    ]
                }, 
                options: {
                   
                    scales: {

                        yAxes: [{
                            ticks:{
                                min:0,
                                max:10,
                            },
                        }],
                        
                    },
                    animation:false,
                },                   

                
            };
        },

    

        methods: {
           
        },
    };
</script>
