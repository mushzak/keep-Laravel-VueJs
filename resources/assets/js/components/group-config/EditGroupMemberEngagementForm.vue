<template>
    <form @submit.prevent="onSubmit">
        <input-select
                id="default_notification_frequency"
                label="Default for New User Notifications Frequency:"
                v-model="form.data.default_notification_frequency"
                :error="form.errors.get('default_notification_frequency')"
                :options="{immediately: 'Immediately', daily: 'Daily'}">
        </input-select>

        <input-select
                id="default_notification_channel"
                label="Default New User Notification Mechanism:"
                v-model="form.data.default_notification_channel"
                :error="form.errors.get('default_notification_channel')"
                :options="{text: 'Text message', email: 'Email'}">
        </input-select>

        <div class="text-right">
            <button type="submit" class="btn btn-secondary" @submit.prevent="onSubmit">Save</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputSelect from "../inputs/InputSelect.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputSelect,
            InputSubmit,
        },

        props: {
            initialGroup: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    default_notification_frequency: this.initialGroup.default_notification_frequency,
                    default_notification_channel: this.initialGroup.default_notification_channel,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/group-configuration/engagement').then(() => {
                    toastr.success("Your group settings have been updated successfully.")
                });
            },

            /**
             * Cancel changes made to this page.
             */
            cancelChanges() {
                window.location.reload();
            },
        },
    }
</script>
