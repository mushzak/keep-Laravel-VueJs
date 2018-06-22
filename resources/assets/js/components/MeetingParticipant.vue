<template>
    <tr>
        <td>
            <span v-text="participant.member.user.name"></span>

            <b v-if="participant.is_present">is present.</b>
            <b v-else>is NOT present.</b>

            <br />

            <span class="text-success" v-if="participant.status == 1">(accepted invite)</span>
            <span class="text-warning" v-else-if="participant.status == 0">(not responded to invite)</span>
            <span class="text-danger" v-else-if="participant.status == 2">(rejected invite)</span>
            <span class="text-muted" v-else-if="participant.status == 3">(may join)</span>
        </td>

        <td class="text-right" v-if="isFacilitator">
            <span v-if="participant.is_present == 1">
                <a href="#" class="btn btn-default btn-sm" @click.prevent="markAsNotPresent">
                    <i class="fa fa-check"></i>
                </a>
            </span>
            <span v-else>
                <a href="#" class="btn btn-default btn-sm" @click.prevent="markAsPresent">
                    <i class="fa fa-square-o"></i>
                </a>
            </span>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            meeting: {
                type: Object,
                required: true,
            },

            participant: {
                type: Object,
                required: true,
            },

            isFacilitator: {
                type: Boolean,
                required: true,
            },
        },

        methods: {
            markAsPresent() {
                axios.patch(`/meetings/${this.meeting.id}/participants/${this.participant.id}`, {
                    is_present: true,
                })
            },

            markAsNotPresent() {
                axios.patch(`/meetings/${this.meeting.id}/participants/${this.participant.id}`, {
                    is_present: false,
                })
            },
        },
    };
</script>