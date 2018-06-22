<template>
    <form @submit.prevent="onSubmit">
        <p class="text-center">There are currently no applications available for integration.  Please check back later.</p>

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
                    //
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/account/integrations').then(() => {
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
