<template>
    <form @submit.prevent="onSubmit">
        <input-text id="subject" label="Subject" v-model="form.data.subject" :error="form.errors.get('subject')"></input-text>
        <input-date id="starts_at" label="Starts at" v-model="form.data.starts_at" :error="form.errors.get('starts_at')"></input-date>
        <input-date id="ends_at" label="Ends at" v-model="form.data.ends_at" :error="form.errors.get('ends_at')"></input-date>
        <input-date id="reminds_at" label="Set a reminder" v-model="form.data.reminds_at" :error="form.errors.get('reminds_at')"></input-date>

        <input-checkbox v-for="(member, index) in members" :key="member.id" v-model="form.data.members[member.id]" :label="members[index].user.name"></input-checkbox>

        <input-submit label="Schedule meeting" :disabled="this.form.isSubmitting"></input-submit>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputDate from "../inputs/InputDate";
    import InputText from "../inputs/InputText";
    import InputSubmit from "../inputs/InputSubmit";

    import moment from "moment";

    export default {
        components: {
            InputCheckbox,
            InputDate,
            InputText,
            InputSubmit,
        },

        props: {
            action: {
                type: String,
                required: true,
            },

            meeting: {
                type: Object,
                required: true,
            },

            members: {
                type: Array,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    subject: this.meeting.subject,
                    starts_at: this.meeting.starts_at,
                    ends_at: this.meeting.ends_at,
                    reminds_at: this.meeting.reminds_at,
                    members: this.meeting.participants.map(({member_id}) => member_id).reduce((participants, participant) => {
                        participants[participant] = true;

                        return participants;
                    }, {}),
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(this.action)
                    .then(data => {
                        window.location.href = data.redirect;
                    });
            },
        },
    };
</script>
