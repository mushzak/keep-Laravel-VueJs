<template>
    <form @submit.prevent="onSubmit">
        <h3>Subscription plan</h3>
        <input-select
                id="plan"
                v-model="form.data.plan"
                :error="form.errors.get('plan')"
                :options="{free: 'Free', professional: 'Professional', enterprise: 'Enterprise'}">
        </input-select>

        <h3>Payment card details</h3>
        <p>This section has not yet been enabled.  Please contact your sales representative for assistance.</p>

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
            initialAccount: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    plan: this.initialAccount.plan,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/account/subscriptions').then(() => {
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
