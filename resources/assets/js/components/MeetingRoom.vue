<template>
    <div class="d-flex justify-content-around">
        <div class="d-inline-block" style="width: 60vw;">
            <b-tabs>
                <b-tab title="Discussion" active>
                    <discussion-thread
                            :initial-discussion="initialDiscussion"
                            :group="group"
                            :members="members">
                    </discussion-thread>
                </b-tab>
                <b-tab title="Action Plan" v-if="meeting.current_participant">
                    <edit-action-plan :member="meeting.current_participant.member"></edit-action-plan>
                </b-tab>
            </b-tabs>
        </div>
        <div class="d-inline-block">
            <div class="" style="height: 80vh; overflow-y: scroll;">
                <p v-if="isFacilitator">
                    <a href="#" class="btn btn-block btn-primary" @click="advanceMeeting">
                        Advance meeting
                    </a>
                </p>

                <div class="card">
                    <div class="card-header">
                        Meeting
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <th>Status</th>
                            <td>
                                <div v-if="meeting.ended_at">
                                    <span class="text-danger">Meeting ended</span>
                                </div>
                                <div v-else-if="meeting.started_at">
                                    <span class="text-success">In progress</span>
                                </div>
                                <div v-else>
                                    <span class="text-primary">Waiting on facilitator</span>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="meeting.current_agenda">
                            <th>Current agenda item</th>
                            <td>
                                <div v-text="meeting.current_agenda.name"></div>
                            </td>
                        </tr>
                        <tr v-if="meeting.current_participant">
                            <th>Current member</th>
                            <td>
                                <div v-text="meeting.current_participant.member.user.name"></div>
                            </td>
                        </tr>
                        <tr v-if="meeting.should_advance_at">
                            <th>Time remaining</th>
                            <td>
                                <div class="text-success" v-if="shouldAdvanceWithin >= 0">
                                    <b>{{ time_remaining }}</b>
                                </div>
                                <div class="text-danger" v-else>
                                    <b>{{ time_remaining }}</b> over!
                                </div>
                            </td>
                        </tr>
                        <tr v-if="! meeting.started_at">
                            <th>Scheduled to start</th>
                            <td>
                                <date-format :value="meeting.starts_at"></date-format>
                            </td>
                        </tr>
                        <tr v-if="! meeting.started_at">
                            <th>Scheduled to end</th>
                            <td>
                                <date-format :value="meeting.ends_at"></date-format>
                            </td>
                        </tr>
                        <tr v-if="meeting.started_at">
                            <th>Started at</th>
                            <td>
                                <date-format :value="meeting.started_at" format="MM/DD/YY h:mm a"></date-format>
                            </td>
                        </tr>
                        <tr v-if="meeting.ended_at">
                            <th>Ended at</th>
                            <td>
                                <date-format :value="meeting.started_at"></date-format>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="card">
                    <div class="card-header">
                        Participants ({{presentCount()}}/{{invitedCount()}})
                    </div>
                    <table class="table">
                        <tbody>
                        <tr is="meeting-participant"
                            v-for="participant in meeting.participants"
                            :meeting="meeting"
                            :participant="participant"
                            :is-facilitator="isFacilitator"
                            :key="participant.id"></tr>
                        </tbody>
                    </table>
                </div>
            
                <p v-if="isFacilitator">
                    <a href="#" class="btn btn-block btn-secondary" @click="rollbackMeeting">
                        Rollback meeting
                    </a>
                </p>
            </div>    
        </div>
    </div>
</template>

<script>
    import MeetingParticipant from "./MeetingParticipant";
    import moment from "moment";

    export default {
        components: {
            MeetingParticipant,
        },

        props: {
            auth: {
                type: Object,
                required: true,
            },

            initialMeeting: {
                type: Object,
                required: true,
            },

            initialDiscussion: {
                type: Object,
                required: true,
            },

            group: {
                type: Object,
                required: true,
            },

            members: {
                type: Array,
                required: true,
            },

            isFacilitator: {
                type: Boolean,
                required: true,
            },
        },

        computed: {
            time_remaining() {
                
                let mins=0;
                let secs=0;
                let total_secs=this.shouldAdvanceWithin;
                let sign=Math.sign(total_secs);
                let formated_time="";
                mins=Math.floor(Math.abs(total_secs/60));
                secs=Math.abs(total_secs%60);
                let s = "00" + secs;
                s=s.substr(s.length-2);
                //let m= "0" + mins;
                //m=m.substr(m.length-1);
                return mins+":"+s;
            },
        },

        data() {
            return {
                shouldAdvanceWithin: "",

                meeting: {
                    group: {},
                    participants: [],
                    messages: [],
                },
            };
        },

        created() {
            this.meeting = this.initialMeeting;

            // Update the time each second to serve as a countdown for when the meeting should advance.
            setInterval(() => {
                if (this.meeting.should_advance_at)
                    this.shouldAdvanceWithin = moment(this.meeting.should_advance_at).diff(moment(), "seconds");
                else
                    this.shouldAdvanceWithin = "";
            }, 250);

            Echo.private(`meetings.${this.meeting.id}`)
                .listen("MeetingUpdated", (e) => {
                    console.log("MeetingUpdated", e);

                    Object.assign(this.meeting, e.meeting);
                })
                .listen("ParticipantUpdated", (e) => {
                    const participantIndex = this.meeting.participants.findIndex(participant => participant.id == e.participant.id);

                    this.$set(this.meeting.participants, participantIndex, e.participant);
                });
        },

        methods: {
            advanceMeeting() {
                window.axios.patch(`/meetings/${this.meeting.id}/advance`);
            },

            rollbackMeeting() {
                window.axios.delete(`/meetings/${this.meeting.id}/rollback`);
            },

            presentCount() {
                return this.meeting.participants.reduce(function (accumulator,participant){
                    return accumulator + participant.is_present;
                },0)
            },

            invitedCount() {
                return this.meeting.participants.length
            },


        },
    };
</script>
