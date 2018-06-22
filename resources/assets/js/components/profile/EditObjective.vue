<template>
    <div>
        <div v-if="isEditingMode">
            <form @submit.prevent="updateObjective" class="d-flex">
                <div style="flex-grow: 2" class="mr-2">
                    <input-text-area
                            v-model="form.data.name"
                            :error="form.errors.get('name')"
                            label="Objective:">
                    </input-text-area>
                </div>
                <div style="flex-grow: 1" class="mr-2">
                    <input-date
                            v-model="form.data.due_at"
                            :error="form.errors.get('due_at')"
                            label="Due Date:">
                    </input-date>
                </div>

                <input-submit label="Update objective" :disabled="this.form.isSubmitting" class="mr-1"></input-submit>

                <div>
                    <button type="button" class="btn btn-secondary" @click.prevent="isEditingMode = false">Cancel</button>
                </div>
            </form>
        </div>
        <div class="d-xs-block d-sm-flex align-items-center" v-else>
            <div class="mr-3">
                <button type="button" class="btn btn-sm btn-outline-secondary" @click.prevent="toggleObjectiveComplete" v-if="objective.completed_at">
                    <i class="fa fa-check"></i>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" @click.prevent="toggleObjectiveComplete" v-else>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </button>
            </div>

            <div class="mr-auto">
                <div>
                    <text-decorator :text="objective.name"></text-decorator>
                </div>
                <div class="text-muted small" v-if="objective.due_at">
                    Due by: <date-format :value="objective.due_at" format="MMMM DD, YYYY, h:mm a"></date-format>
                </div>
                <div class="text-muted small" v-if="objective.completed_at">
                    Completed on: <date-format :value="objective.completed_at" format="MMMM DD, YYYY, h:mm a"></date-format>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-secondary mr-1"
                    @click.prevent="editToggleObjective()">
                <i class="fa fa-edit"></i>
            </button>

            <button type="button" class="btn btn-sm btn-outline-danger mr-1" @click.prevent="deleteObjective">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputDate from "../inputs/InputDateDMH.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import TextDecorator from "../TextDecorator.vue";

    export default {
        components: {
            InputDate,
            InputTextArea,
            InputSubmit,
            TextDecorator,
        },

        props: {
            member: {
                type: Object,
                required: true,
            },

            objective: {
                type: Object,
                required: true,
            },

            goal: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isEditingMode: false,

                form: new Form({
                    name: this.objective.name,
                    due_at: this.objective.due_at,
                    completed_at:this.objective.completed_at,
                }),

                updateObjectives:false,

            };
        },

        watch : {
            updateObjectives :function(val) {
                this.orderedObjectives();
            },
        },

        methods: {
            updateObjective() {
                this.form.patch(`/members/${this.member.id}/objectives/${this.objective.id}`)
                    .then(data => {
                        this.isEditingMode = false;

                        for(let o = 0;o<this.goal.objectives.length;o++){
                            if(this.goal.objectives[o].name == this.objective.name && this.goal.objectives[o].due_at == this.objective.due_at && this.goal.objectives[o].completed_at == this.objective.completed_at){
                                this.goal.objectives[o].name = this.form.data.name;
                                this.goal.objectives[o].due_at = this.form.data.due_at;
                                this.goal.objectives[o].completed_at = this.form.data.completed_at;
                            }
                        }

                        this.objective.name = this.form.data.name;
                        this.objective.due_at = this.form.data.due_at;
                        this.objective.completed_at = this.form.data.completed_at;

                        this.updateparent();
                        toastr.success("The objective has been updated successfully.");
                    });
            },

            updateparent(){
                this.updateObjectives = !this.updateObjectives;
            },

            toggleObjectiveComplete() {
                axios.patch(`/members/${this.member.id}/objectives/${this.objective.id}/completed`)
                    .then(data => {
                        toastr.success("The objective has been updated successfully.");
                    });
            },

            deleteObjective() {
                swal({
                    title: "Want to delete this?",
                    text: "Are you sure you want to delete this objective?  You will not be able to reverse this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-secondary",
                }).then(() => {
                    axios.delete(`/members/${this.member.id}/objectives/${this.objective.id}`)
                        .then(data => {
                            toastr.success("The objective has been deleted successfully.");
                        });
                });
            },

            orderedObjectives(){
                this.goal.objectives.sort(function(a, b)
                {
                    var x=a.due_at, y=b.due_at;
                    return x<y ? -1 : x>y ? 1 : 0;
                });
            },

            editToggleObjective() {
                 this.form.data.name = this.objective.name ;
                 this.form.data.due_at = this.objective.due_at;
                 this.form.data.completed_at = this.objective.completed_at;
                 this.isEditingMode = !this.isEditingMode;
            }
        },
    };
</script>
