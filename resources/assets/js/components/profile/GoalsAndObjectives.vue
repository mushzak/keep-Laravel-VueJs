<template>
    <div class="card mb-3" id="update-goals-and-objectives">
        <div class="card-header">Goals and Objectives</div>
        <div class="card-body">
            <p class="lead">{{goal.name}}</p>
        </div>
        <ul class="list-group list-group-flush" v-if="goal">
            <li v-for="objective in goal.objectives"
                    class="list-group-item clearfix">
                    
                    <i v-if="objective.completed_at" class="fa fa-check"></i>
                    <i v-else class="fa fa-square-o"></i>

                    <del v-if="objective.is_blocked">{{ objective.name }}</del>
                    <span v-else>{{ objective.name }}</span>
            </li>
        </ul>
    </div>
</template>

<script>


    export default {
        components: {
            
        },

        props: {
            member: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isAddingNewObjective: false,

                goal: this.member.last_goal,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("GoalCreated", (e) => {
                    console.log('A goal was created for this member.');

                    window.location.reload();
                })
                .listen("GoalUpdated", (e) => {
                    console.log('A goal was updated for this member.');

                    if (e.goal.id == this.goal.id)
                        this.goal.name = e.goal.name;
                    else
                        window.location.reload();
                })
                .listen("GoalDeleted", (e) => {
                    console.log('A goal was deleted for this member.');

                    window.location.reload();
                })
                .listen("ObjectiveCreated", (e) => {
                    console.log('A objective was created for this member.');

                    this.goal.objectives.push(e.objective);
                })
                .listen("ObjectiveUpdated", (e) => {
                    console.log('A objective was updated for this member.');

                    let objectiveIndex = this.goal.objectives.findIndex(objective => objective.id == e.objective.id);

                    this.$set(this.goal.objectives, objectiveIndex, e.objective);
                })
                .listen("ObjectiveDeleted", (e) => {
                    console.log('A objective was deleted for this member.');

                    let objectiveIndex = this.goal.objectives.findIndex(objective => objective.id == e.objective.id);

                    this.goal.objectives.splice(objectiveIndex, 1);
                });
        },

        methods: {
        },
    }
</script>
