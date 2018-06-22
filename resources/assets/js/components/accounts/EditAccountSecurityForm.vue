<template>
    <form @submit.prevent="onSubmit">
        <input-checkbox
                label="Enable 2 factor authentication?"
                v-model="form.data.is_using_2fa"
                :error="form.errors.get('is_using_2fa')">
        </input-checkbox>

        <div class="text-right">
            <button type="submit" class="btn btn-secondary" @submit.prevent="onSubmit">Save</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputCheckbox,
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
                    is_using_2fa: this.initialAccount.is_using_2fa,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/account/security').then(() => {
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
