<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center">
                <div class="mr-auto">Commitments</div>
                <div>
                    <select class="form-control form-control-sm" v-model="selectedProcessNumber">
                        <option v-for="processNumber in processNumbers" :value="processNumber">
                            Commitment Date <span v-if="createdAt[processNumber-1]">{{createdAt[processNumber-1]['created_at']}}</span>
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div v-if="! memberHasCommitmentForCurrentProcess">
                    <p class="text-danger lead"><b>You don't have a commitment for this process cycle.</b>  You can use the form below to create a new commitment for this process.</p>
                </div>

                <div v-if="currentCommitmentCompletedAt">
                    <p class="text-success lead">
                        You completed this commitment on <date-format :value="currentCommitmentCompletedAt" format="MMMM DD, YYYY"></date-format>.  Great job!
                    </p>
                </div>

                <input-text-area
                        id="ask"
                        label="Ask"
                        v-model="form.data.ask"
                        :error="form.errors.get('ask')">
                </input-text-area>
                <input-text-area
                        id="backstory"
                        label="Backstory"
                        v-model="form.data.backstory"
                        :error="form.errors.get('backstory')">
                </input-text-area>
                <input-text-area
                        id="commitment"
                        label="Commitment"
                        v-model="form.data.name"
                        :error="form.errors.get('name')">
                </input-text-area>
                <input-text-area
                        id="outcome"
                        label="Status"
                        v-model="form.data.outcome"
                        :error="form.errors.get('outcome')">
                </input-text-area>
            </div>
            <div class="card-footer d-flex align-items-center">
                <div class="mr-auto">
                    <div v-if="memberHasCommitmentForCurrentProcess">
                        <button type="button" class="btn btn-outline-secondary" v-if="this.currentCommitmentCompletedAt" @click.prevent="toggleCompleteStatus">
                            Mark as incomplete
                        </button>
                        <button type="button" class="btn btn-outline-secondary" v-else-if="!this.currentCommitmentCompletedAt" @click.prevent="toggleCompleteStatus">
                            Mark as complete
                        </button>
                    </div>
                </div>
                <div>
                    <input-submit :classes="affirmClass" :label="form.hasChanges ? 'Save' : 'Affirm'" :disabled="form.isSubmitting"></input-submit>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import _ from "lodash";
    import Form from "../../utilities/Form";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputTextArea,
            InputSubmit,
        },

        props: {
            member: {
                type: Object,
                required: true,
            },
        },

        computed: {
            processNumbers() {
                return _.range(this.member.group.current_process, 0);
            },
            createdAt() {
                return this.member.commitments;
            },
            memberHasCommitmentForCurrentProcess() {
                return Boolean(this.getCommitmentIndexByProcessNumber(this.selectedProcessNumber) >= 0) ? true : false;
            },  

            needAffirm: function() {
                let return_value=0;
                this.flags.forEach(function(flag){
                    if(flag.type=="updated-action-plan" && flag.resolved_at==null){
                        return_value=1;
                    }
                });
                return return_value            
            }, 


            affirmClass: function() {
                let return_value=["btn-secondary"];
                if(this.needAffirm==1){
                    return_value=["btn-primary"];
                }
                return return_value         
            },  

        },

        watch: {
            selectedProcessNumber(value) {
                this.updateCommitmentForm(value);
            },

            member(value) {
                this.commitments = this.member.commitments;
                this.flags = this.member.open_flags;

                this.updateCommitmentForm(this.selectedProcessNumber);
            },
        },

        data() {
            return {
                commitments: this.member.commitments,
                flags: this.member.open_flags,

                currentCommitmentId: null,
                currentCommitmentCompletedAt: null,
                currentCommitmentUpdatedAt: null,
                selectedProcessNumber: this.member.group.current_process,

                form: new Form({
                    selectedProcessNumber: null,
                    name: '',
                    ask: '',
                    backstory: '',
                    outcome: '',
                }),

            };
        },

        mounted() {
            // Update current form
            this.updateCommitmentForm(this.selectedProcessNumber);

            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("CommitmentCreated", (e) => {
                    console.log('A commitment was created for this member.');

                    this.commitments.push(e.commitment);

                    if (e.commitment.process_number == this.selectedProcessNumber)
                        this.updateCommitmentForm(this.selectedProcessNumber);
                })
                .listen("CommitmentUpdated", (e) => {
                    console.log('A commitment was updated for this member.');

                    const commitmentIndex = this.getCommitmentIndexByProcessNumber(e.commitment.process_number);

                    this.$set(this.commitments, commitmentIndex, e.commitment);

                    if (e.commitment.process_number == this.selectedProcessNumber)
                        this.updateCommitmentForm(this.selectedProcessNumber);
                })
                .listen("FlagUpdated", (e) => {
                    console.log('A flag for this member was updated.');
                    let flagIndex = this.flags.findIndex(flag => flag.id == e.flag.id);

                    this.$set(this.flags, flagIndex, e.flag);

                });
        },

        methods: {
            /**
             * Triggers when the user wishes to create a new commitment
             */
            onSubmit() {
                this.form.post(`/members/${this.member.id}/commitments`)
                    .then(data => {
                        toastr.success("Your action plan has been updated successfully.");
                    });
            },

            toggleCompleteStatus() {
                axios.patch(`/members/${this.member.id}/commitments/${this.currentCommitmentId}/completed`, [])
                    .then(data => {
                        toastr.success("Your action plan has been updated successfully.");
                    });
            },

            /**
             * If something happens where the data in the form no longer matches the data in the active commitment,
             * this will change the form.
             */
            updateCommitmentForm(processNumber) {
                const commitmentIndex = this.getCommitmentIndexByProcessNumber(processNumber);
                this.form.data.process_number = processNumber;

                if (commitmentIndex >= 0) {
                    this.form.data.name = this.commitments[commitmentIndex].name;
                    this.form.data.ask = this.commitments[commitmentIndex].ask;
                    this.form.data.backstory = this.commitments[commitmentIndex].backstory;
                    this.form.data.outcome = this.commitments[commitmentIndex].outcome;

                    this.currentCommitmentId = this.commitments[commitmentIndex].id;
                    this.currentCommitmentCompletedAt = this.commitments[commitmentIndex].completed_at;
                    this.currentCommitmentUpdatedAt = this.commitments[commitmentIndex].updated_at;
                }
                else {
                    this.form.data.name = "";
                    this.form.data.ask = "";
                    this.form.data.backstory = "";
                    this.form.data.outcome = "";

                    this.currentCommitmentId = null;
                    this.currentCommitmentCompletedAt = null;
                    this.currentCommitmentUpdatedAt =null;
                }
            },

            getCommitmentIndexByProcessNumber(processNumber) {
                return this.commitments.findIndex(participant => participant.process_number == processNumber);
            },


        },
    };
</script>
