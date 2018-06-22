<template>
    <form @submit.prevent="onSubmit">
        <h3>Big picture</h3>

        <input-checkbox
                label="Include big picture?"
                v-model="form.data.is_using_big_picture"
                :error="form.errors.get('is_using_big_picture')">
        </input-checkbox>

        <input-text
                label="Vision"
                v-model="form.data.vision_label"
                :error="form.errors.get('vision_label')">
        </input-text>

        <input-text
                label="Values"
                v-model="form.data.values_label"
                :error="form.errors.get('values_label')">
        </input-text>

        <input-text
                label="Mission"
                v-model="form.data.mission_label"
                :error="form.errors.get('mission_label')">
        </input-text>

        <h3>Personal motivation</h3>

        <input-checkbox
                label="Include personal motivation?"
                v-model="form.data.is_using_personal_motivation"
                :error="form.errors.get('is_using_personal_motivation')">
        </input-checkbox>

        <input-text
                label="Why"
                v-model="form.data.why_label"
                :error="form.errors.get('why_label')">
        </input-text>

        <input-text
                label="Consequences"
                v-model="form.data.consequences_label"
                :error="form.errors.get('consequences_label')">
        </input-text>

        <h3>Professional background</h3>

        <input-checkbox
                label="Include professional background?"
                v-model="form.data.is_using_professional_background"
                :error="form.errors.get('is_using_professional_background')">
        </input-checkbox>

        <input-text
                label="Company Name"
                v-model="form.data.company_name_label"
                :error="form.errors.get('company_name_label')">
        </input-text>

        <input-text
                label="Company Bio"
                v-model="form.data.company_bio_label"
                :error="form.errors.get('company_bio_label')">
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
                    is_using_big_picture: this.initialGroup.is_using_big_picture,
                    is_using_personal_motivation: this.initialGroup.is_using_personal_motivation,
                    is_using_professional_background: this.initialGroup.is_using_professional_background,

                    vision_label: this.initialGroup.vision_label,
                    values_label: this.initialGroup.values_label,
                    mission_label: this.initialGroup.mission_label,
                    why_label: this.initialGroup.why_label,
                    consequences_label: this.initialGroup.consequences_label,
                    company_name_label: this.initialGroup.company_name_label,
                    company_bio_label: this.initialGroup.company_bio_label,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post("/group-configuration/profiles").then(() => {
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
