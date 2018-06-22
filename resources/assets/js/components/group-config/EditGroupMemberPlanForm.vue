<template>
    <form @submit.prevent="onSubmit">
        <h3>Commitments</h3>

        <input-checkbox
                label="Ask"
                v-model="form.data.is_using_ask"
                :error="form.errors.get('is_using_ask')">
        </input-checkbox>

        <input-text
                v-model="form.data.ask_label"
                :error="form.errors.get('ask_label')">
        </input-text>

        <input-checkbox
                label="Backstory"
                v-model="form.data.is_using_backstory"
                :error="form.errors.get('is_using_backstory')">
        </input-checkbox>

        <input-text
                v-model="form.data.backstory_label"
                :error="form.errors.get('backstory_label')">
        </input-text>

        <input-checkbox
                label="Commitment"
                v-model="form.data.is_using_commitment"
                :error="form.errors.get('is_using_commitment')">
        </input-checkbox>

        <input-text
                v-model="form.data.commitment_label"
                :error="form.errors.get('commitment_label')">
        </input-text>

        <input-checkbox
                label="Status"
                v-model="form.data.is_using_outcome"
                :error="form.errors.get('is_using_outcome')">
        </input-checkbox>

        <input-text
                v-model="form.data.outcome_label"
                :error="form.errors.get('outcome_label')">
        </input-text>

        <h3>Goals and objectives</h3>

        <input-checkbox
                label="Include goals and objectives?"
                v-model="form.data.is_using_goal"
                :error="form.errors.get('is_using_goal')">
        </input-checkbox>

        <input-text
                label="Goal"
                v-model="form.data.goal_label"
                :error="form.errors.get('goal_label')">
        </input-text>

        <input-text
                label="Objective"
                v-model="form.data.objective_label"
                :error="form.errors.get('objective_label')">
        </input-text>

        <div class="text-right">
            <button type="submit" class="btn btn-secondary" @submit.prevent="onSubmit">Save</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputText from "../inputs/InputText.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputCheckbox,
            InputText,
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
                    is_using_ask: this.initialGroup.is_using_ask,
                    is_using_backstory: this.initialGroup.is_using_backstory,
                    is_using_commitment: this.initialGroup.is_using_commitment,
                    is_using_outcome: this.initialGroup.is_using_outcome,
                    is_using_goal: this.initialGroup.is_using_goal,

                    ask_label: this.initialGroup.ask_label,
                    backstory_label: this.initialGroup.backstory_label,
                    commitment_label: this.initialGroup.commitment_label,
                    outcome_label: this.initialGroup.outcome_label,
                    goal_label: this.initialGroup.goal_label,
                    objective_label: this.initialGroup.objective_label,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post("/group-configuration/planning").then(() => {
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
    };
</script>
