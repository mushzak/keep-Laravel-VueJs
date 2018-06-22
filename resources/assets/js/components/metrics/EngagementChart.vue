<template>
    <base-chart type="bar" :data="data" :options="options"></base-chart>
</template>

<script>
    import BaseChart from "./BaseChart.vue";

    export default {
        components: {
            BaseChart,
        },

        props: {
            discussions: {
                type: Array,
                required: true,
            },

            members: {
                type: Array,
                required: true,
            },
            graph_only: {
                default:false,
            },
            colors:{
                required:false,
                default:function () {return ['#28a745','#dc3545',]},
            }  
        },

        data() {
            return {
                data: {
                    labels: this.getMemberNames(),
                    datasets: [
                        {
                            label: "Engagement provided",
                            backgroundColor: this.colors[0],
                            data: this.getDiscussionCountsByMember(),
                        },
                    ],
                },

                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            display: !this.graph_only ,
                            scaleLabel:{
                                display:true,
                                labelString:'Engagement Actions',
                                padding:15,
                                fontStyle:'Bold'
                            }
                        }],
                        xAxes:[{
                            ticks: {
                                beginAtZero: true,
                                autoSkip:false,
                            },
                            display: !this.graph_only ,
                            scaleLabel:{
                                display:true,
                                labelString:'Members',
                                fontStyle:'Bold'
                            }
                            
                        }],
                    },
                    animation:false,
                    legend: {
                        display: !this.graph_only},
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

            /**
             * Returns an array of the discussion counts for each member.
             *
             * @return {array}
             */
            getDiscussionCountsByMember() {
                return this.members.reduce((discussionCounts, member) => {
                    let discussionCountForMember = this.discussions.filter((discussion) => {
                        return discussion.target_id == member.id;
                    }).length;

                    discussionCounts.push(discussionCountForMember);
                    return discussionCounts;
                }, []);
            }
        }
    };
</script>
