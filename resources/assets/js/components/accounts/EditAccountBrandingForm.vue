<template>
    <form @submit.prevent="onSubmit">
        <input-checkbox
                label="Activate custom branding?"
                v-model="form.data.use_custom_branding"
                :error="form.errors.get('use_custom_branding')">
        </input-checkbox>

        <div class="mb-3" v-if="initialAccount.custom_logo">
            <img :src="'/storage/' + initialAccount.custom_logo" class="img-fluid img-thumbnail rounded" style="max-height: 200px; max-width: 200px" />
        </div>
        <div class="mb-3" v-else>
            [no image uploaded]
        </div>

        <input-file
                id="avatar"
                label="Change custom logo"
                @input="(file) => { form.data.custom_logo = file }"
                :error="form.errors.get('custom_logo')">
        </input-file>

        <div class="text-right">
            <button type="submit" class="btn btn-secondary" @submit.prevent="onSubmit">Save</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputFile from "../inputs/InputFile.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputCheckbox,
            InputFile,
            InputSubmit,
        },

        props: {
            initialAccount: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    use_custom_branding: this.initialAccount.use_custom_branding,

                    custom_logo: this.initialAccount.custom_logo,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/account/branding').then(() => {
                    toastr.success("Your account settings have been updated successfully.")
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
