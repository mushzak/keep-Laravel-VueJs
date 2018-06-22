<template>
    <form @submit.prevent="onSubmit">
        <input-select
                id="check_in_interval"
                label="Frequency"
                v-model="form.data.check_in_interval"
                :error="form.errors.get('check_in_interval')"
                :options="checkInOptions">
        </input-select>

        <input-select
                id="pace"
                label="Pace"
                v-model="form.data.pace"
                :error="form.errors.get('pace')"
                :options="{0: 'Self-Guided', 1: 'Coached'}">
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
                checkInOptions: {
                    0: "(do not enforce)",
                    1: "Once a day",
                    7: "Once a week",
                    14: "Once every two weeks",
                    30: "Once a month",
                    60: "Once every two months"
                },

                form: new Form({
                    check_in_interval: this.initialGroup.check_in_interval,
                    pace: this.initialGroup.pace,
                })
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/group-configuration/check-ins').then(() => {
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
