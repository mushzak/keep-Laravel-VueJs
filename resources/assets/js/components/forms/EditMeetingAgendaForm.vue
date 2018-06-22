<template>
    <form @submit.prevent="onSubmit">
        <input-text id="name" label="Agenda title" v-model="form.data.name"
                    :error="form.errors.get('name')"></input-text>

        <input-number id="duration" label="Duration" min="1" v-model="form.data.duration"
                      :error="form.errors.get('duration')">
            <span class="help-block text-muted">How many minutes should this last?</span>
        </input-number>

        <input-number id="order" label="Order" min="1" v-model="form.data.order" :error="form.errors.get('order')">
            <span class="help-block text-muted">In what order should this appear on the agenda?</span>
        </input-number>

        <input-checkbox label="Only for facilitator?" v-model="form.data.is_facilitator_only"
                        :error="form.errors.get('is_facilitator')">
            <span class="help-block text-muted">Is this agenda item reserved for the facilitator, or should the time be divided by the present members?</span>
        </input-checkbox>

        <input-submit label="Update agenda item" :disabled="this.form.isSubmitting"></input-submit>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputNumber from "../inputs/InputNumber";
    import InputText from "../inputs/InputText";
    import InputSubmit from "../inputs/InputSubmit";

    export default {
        components: {
            InputCheckbox,
            InputNumber,
            InputText,
            InputSubmit,
        },

        props: {
            meeting: {
                type: Object,
                required: true,
            },

            agenda: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    name: this.agenda.name,
                    duration: this.agenda.duration,
                    order: this.agenda.order,
                    is_facilitator_only: this.agenda.is_facilitator_only,
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/meetings/${this.meeting.id}/agendas/${this.agenda.id}`)
                    .then(data => {
                        window.location.href = data.redirect;
                    });
            },
        },
    };
</script>
