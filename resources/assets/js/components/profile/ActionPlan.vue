<template>
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center">
                <div class="mr-auto">Action Plan</div>
                <div>
                    <select class="form-control form-control-sm" v-model="selectedProcessNumber">
                        <option v-for="processNumber in processNumbers" :value="processNumber">
                            Commitment Date <span v-if="createdAt[processNumber-1]">{{createdAt[processNumber-1]['created_at']}}</span>
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <b>Ask</b>
                <p class="dmh-preserve-text-area">{{ask}}</p >
                <b>Backstory</b>
                <p class="dmh-preserve-text-area">{{backstory}}</p>
                <b>Commitment</b>
                <p class="dmh-preserve-text-area">{{commitment}}</p>
                <b>Status</b>
                <p class="dmh-preserve-text-area">{{outcome}}</p>
                <div v-if="currentCommitmentCompletedAt">
                    <b>Date Completed</b>
                    <date-format :value="currentCommitmentCompletedAt" format="MM/DD/YY"></date-format>
                </div>
            </div>
        </div>
</template>

<script>
    import _ from "lodash";

    export default {
        components: {
        },

        props: {
            member: {
                type: Object,
                required: true,
            },

            group:{
                type: Object,
                required: true,
            },
        },

        computed: {
            processNumbers() {
                return _.range(this.group.current_process, 0);
            },
            createdAt() {
                return this.member.commitments;
            },
            memberHasCommitmentForCurrentProcess() {
                return Boolean(this.getCommitmentIndexByProcessNumber(this.selectedProcessNumber) >= 0) ? true : false;
            },
        },

        watch: {
            selectedProcessNumber(value) {
                this.updateCommitment(value);
            },
        },

        data() {
            return {
                commitments: this.member.commitments,

                currentCommitmentId: null,
                currentCommitmentCompletedAt: null,
                selectedProcessNumber: this.group.current_process,
                ask :"",
                backstory :"",
                outcome :"",
                commitment:"",
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("CommitmentUpdated", (e) => {
                    console.log('A commitment was updated for this member.');

                    const commitmentIndex = this.getCommitmentIndexByProcessNumber(e.commitment.process_number);

                    this.$set(this.commitments, commitmentIndex, e.commitment);
                    this.updateCommitment(this.selectedProcessNumber);
                 });
            this.updateCommitment(this.selectedProcessNumber);
        },

        methods: {

            /**
             * If something happens where the data in the form no longer matches the data in the active commitment,
             * this will change the form.
             */
            updateCommitment(processNumber) {
                const commitmentIndex = this.getCommitmentIndexByProcessNumber(processNumber);
                this.process_number = processNumber;

                if (commitmentIndex >= 0) {
                    this.commitment = this.commitments[commitmentIndex].name;
                    this.ask = this.commitments[commitmentIndex].ask;
                    this.backstory = this.commitments[commitmentIndex].backstory;
                    this.outcome = this.commitments[commitmentIndex].outcome;

                    this.currentCommitmentId = this.commitments[commitmentIndex].id;
                    this.currentCommitmentCompletedAt = this.commitments[commitmentIndex].completed_at;
                }
                else {
                    this.ask = "";
                    this.backstory = "";
                    this.commitment="";
                    this.outcome = "";

                    this.currentCommitmentId = null;
                    this.currentCommitmentCompletedAt = null;
                }
            },

            getCommitmentIndexByProcessNumber(processNumber) {
                return this.commitments.findIndex(participant => participant.process_number == processNumber);
            },
        },
    };
</script>
