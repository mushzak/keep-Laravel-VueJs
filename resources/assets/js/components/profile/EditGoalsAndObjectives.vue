<template>
    <div class="card mb-3" id="update-goals-and-objectives">
        <div class="card-header">Goals and Objectives</div>
        <div class="card-body">
            <edit-goal :member="member" :goal="goal"></edit-goal>
        </div>
        <ul class="list-group list-group-flush" v-if="goal">
            <li
                    is="edit-objective"
                    v-for="objective in goal.objectives"
                    :member="member"
                    :objective="objective"
                    :goal="goal"
                    class="list-group-item">
            </li>
            <li
                    is="add-objective"
                    v-if="isAddingNewObjective"
                    :member="member"
                    class="list-group-item">
            </li>
        </ul>
        <div class="card-footer d-flex align-items-center">
            <div class="mr-auto">
                <button type="button" class="btn btn-secondary " @click.prevent="isAddingNewObjective = !isAddingNewObjective">
                    New objective
                </button>
            </div>
            <div>
                <button :class="affirmClass" type="button" @click.prevent="affirmGoal">
                    Affirm
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";

    import AddObjective from "./AddObjective.vue";
    import EditGoal from "./EditGoal.vue";
    import EditObjective from "./EditObjective.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            AddObjective,
            EditGoal,
            EditObjective,
            InputTextArea,
            InputSubmit,
        },

        props: {
            member: {
                type: Object,
                required: true,
            },
        },

        computed:{
            needAffirm: function() {
                let return_value=0;
                this.flags.forEach(function(flag){
                    if(flag.type=="updated-goals-and-objectives" && flag.resolved_at==null){
                        return_value=1;
                    }
                });
                return return_value             
            },   

            affirmClass: function() {
                let return_value=["btn btn-secondary"];
                if(this.needAffirm==1){
                    return_value= ["btn btn-primary"];
                }
                return return_value         
            },  
        },

        data() {
            return {
                isAddingNewObjective: false,

                goal: this.member.last_goal,

                flags:this.member.open_flags,
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
                })
                .listen("FlagUpdated", (e) => {
                    console.log('A flag for this member was updated.');
                    let flagIndex = this.flags.findIndex(flag => flag.id == e.flag.id);

                    this.$set(this.flags, flagIndex, e.flag);

                });
        },

        methods: {
            affirmGoal() {
                axios.patch(`/members/${this.member.id}/goals/${this.goal.id}`, {}).then(data => {
                    toastr.success('Your goal has been affirmed.');
                });
            },
        },
    }
</script>
