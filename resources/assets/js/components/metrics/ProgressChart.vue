<template>
    <base-chart type="bar" :data="data" :options="options" :triggerUpdate="triggerUpdate"></base-chart>
</template>

<script>
    import BaseChart from "./BaseChart.vue";
    import moment from "moment";

    export default {
        components: {
            BaseChart,
        },

        props: {
            objectives: {
                type: Array,
                required: true,
            },

            period: {
                type: String,
                default: "week",
            },

            graph_only: {
                default:false,
            },  
            colors:{
                required:false,
                default:function () {return ['#28a745','#dc3545','#007bff']},
            }         

        },

        data() {
            return {
                completedCountsOverX: [],
                totalCountsOverX: [],
                triggerUpdate: 0,

                data: {
                    datasets: [
                        {
                            label: "Completed",
                            backgroundColor: this.colors[0],
                            //steppedLine: true,
                            pointRadius:1,
                            data: [],
                        },
                        {
                            label: "Total Due",
                            backgroundColor: this.colors[1],
                            //steppedLine: true,
                            pointRadius:1,
                            data: [],
                        },
                        {
                            label: "Today",
                            backgroundColor: this.colors[2],
                            //steppedLine: true,
                            pointRadius:1,
                            data: [],
                        },
                    ],
                },

                options: {
                    legend:{
                        display: !this.graph_only ,
                    },
                    scales: {
                        xAxes: [{
                            type: 'time',
                            distribution: 'linear',
                            stacked: true,
                            bounds:'data',
                            time: {
                                tooltipFormat:'MMM D',
                                //unit: this.period,
                            },
                            display: !this.graph_only, 
                            scaleLabel:{
                                display:true,
                                labelString:'Date',
                                padding:15,
                                fontStyle:'Bold'
                            },
                            barPercentage:1,
                            categoryPercentage:1,
                        }],
                        yAxes: [{
                            // ticks: {
                            //     beginAtZero: true
                            // },
                            display: !this.graph_only ,
                            scaleLabel:{
                                display:true,
                                labelString:'Number of Objectives',
                                padding:15,
                                fontStyle:'Bold'
                            },
                            borderWidth:0,
                        }],
                        
                        
                    },
                    animation:false,
                },
            };
        },

        mounted() {
            this.generateDataForEachX();
        },

        methods: {
            maxDate() {
                return this.objectives.reduce((maxDate, objective) => {
                    if (moment(objective.due_at).isSameOrAfter(maxDate)) {
                        maxDate=moment(objective.due_at);
                    }
                    return maxDate;
                }, 0);
            },

            completed(objective) {
                return !objective.completed_at;
            },

            completedCountX(){
                return this.objectives.reduce((completedCountX,objective)=>{
                    if(objective.completed_at) {
                        completedCountX++;
                    };
                    return completedCountX;
                },0);
            },
        
            /**
             * Loop through and plot each slice of X onto the graph.
             */
            generateDataForEachX() {
                let upwardTimeBound = moment(this.maxDate()._i).add(1,this.period);
                let completedCount = 0;
                let totalCount = 0;
                let maxCount=this.getCompletedOrDueBeforeDate(upwardTimeBound);

                this.data.datasets[0].data = [];
                this.data.datasets[1].data = [];
                this.data.datasets[2].data = [];

                do {
                    // Get the counts for this slice of the X.
                    
                    totalCount = this.getCompletedOrDueBeforeDate(upwardTimeBound);
                    if(this.completedCountX() >= totalCount){
                        completedCount=totalCount;
                    }else{
                        completedCount=0;
                    }

                    // Add the counts to their respective lines.
                    this.data.datasets[0].data.push({x: upwardTimeBound.clone(), y: completedCount});
                    this.data.datasets[1].data.push({x: upwardTimeBound.clone(), y: totalCount});

                    //determine if timebound is today
                    if(moment(upwardTimeBound).isSame(moment(),'week')){
                        this.data.datasets[2].data.push({x: upwardTimeBound.clone(), y: maxCount});
                    }else{
                        this.data.datasets[2].data.push({x: upwardTimeBound.clone(), y: 0});
                    }; 

                    // Decrement the upward time bound, so that we can get the next slice of
                    // the X graph.
                    upwardTimeBound.subtract(1, this.period);
                }
                while (totalCount > 0);

                // Make the underlying base chart trigger an update.
                this.triggerUpdate++;
            },

            /**
             * Get the count for all objectives that were completed by the given upward time bound.
             *
             * @param upwardTimeBound
             * @return {number}
             */
            getCompletedBeforeDate(upwardTimeBound) {
                return this.objectives.reduce((currentCount, objective) => {
                    if (objective.completed_at && moment(objective.completed_at).isSameOrAfter(upwardTimeBound)) {
                        currentCount++;
                    }

                    return currentCount;
                }, 0);
            },

            /**
             * Get the count for all objectives that were completed + all that were due
             * by the given upward time bound.
             *
             * @param upwardTimeBound
             * @return {number}
             */
            getCompletedOrDueBeforeDate(upwardTimeBound) {
                return this.objectives.reduce((currentCount, objective) => {
                    if (
                        (
                            objective.completed_at &&
                            moment(objective.completed_at).isSameOrBefore(upwardTimeBound)
                        )
                        ||
                        (
                            objective.due_at &&
                            moment(objective.due_at).isSameOrBefore(upwardTimeBound)
                        )
                    ) {
                        currentCount++;
                    }

                    return currentCount;
                }, 0);
            },
        },
    };
</script>
