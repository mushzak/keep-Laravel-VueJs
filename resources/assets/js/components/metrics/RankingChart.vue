<template>
    <base-chart type="horizontalBar" :data="data" :options="options"></base-chart>
</template>

<script>
    import BaseChart from "./BaseChart.vue";
    import moment from "moment";

    export default {
        components: {
            BaseChart,
        },

        props: {
            members: {
                type: Array,
                required: true,
            },

            value: {
                type: String,
                required: true,
            },
        },

        data() {
            return {
                data: {
                    labels: this.getLabels(),
                    datasets: [{
                        data: this.getValues(),
                        backgroundColor: this.getColors(),
                        // Other color options
                        // "rgba(128, 191,142, 1)", // green
                        // "rgba(128, 155,191, 1)", // blue
                        // "rgba(183, 193,185, 1)", // gray
                        // "rgba(220, 53,69, 1)", // red
                    },]
                },

                options: {
                    legend: {
                        display: false,
                    },
                    scales: {
                        xAxes: [{
                            type: "linear",
                            stacked: false,
                            bounds: "data",
                            ticks:{
                                min:0,
                            },
                        }],
                        yAxes: [{
                            // ticks: {
                            //     beginAtZero: true
                            // },
                            type: "category",
                        }],

                    },
                    animation: false,
                },
            };
        },

        methods: {
            /**
             * Returns an array of the member names.
             *
             * @return {array}
             */
            getMemberNames() {
                return this.members.reduce((memberNames, member) => {
                    memberNames.push(member.user.name);
                    return memberNames;
                }, []);
            },

            getLabels() {
                let names=this.getMemberNames();
                names.unshift('Average');
                return names;
            },


            getMemberValues() {
                return this.members.reduce((memberValues, member) => {
                    memberValues.push(member[this.value]);
                    return memberValues;
                }, []);
            },

            getValues() {
                let values=this.getMemberValues();
                values.unshift(this.getAvg());
                return values;
            },

            getMax(){
                return Math.max.apply(Math,this.getMemberValues());
            },

            getMin(){
                return Math.min.apply(Math,this.getMemberValues());
            },

            getAvg(){
                let values=this.getMemberValues();
                let len=values.length;
                let total=0;
                let avg=0;

                for(let i=0 ; i<len ; i++){
                            total +=values[i];
                            avg=total/len; 
                }
                return avg;
            },

            getMemberColors() {
                return this.members.reduce((memberColors, member) => {
                    let color="rgba(183, 193,185, 1)";
                    if(member[this.value]==this.getMax()){
                        color="rgba(128, 191,142, 1)";
                    }
                    if(member[this.value]==this.getMin()){
                        color="rgba(220, 53,69, 1)";
                    }
                    memberColors.push(color);
                    return memberColors;
                }, []);
            },

            getColors() {
                let colors=this.getMemberColors();
                colors.unshift("rgba(128, 155,191, 1)");
                return colors;
            },
        },
    };
</script>
