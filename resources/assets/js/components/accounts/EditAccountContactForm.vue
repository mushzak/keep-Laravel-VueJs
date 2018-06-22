<template>
    <form @submit.prevent="onSubmit">
        <input-text
                label="Account Name"
                v-model="form.data.name"
                :error="form.errors.get('name')">
        </input-text>

        <input-text
                label="Business Name"
                v-model="form.data.business_name"
                :error="form.errors.get('business_name')">
        </input-text>

        <input-text
                label="Business Phone"
                v-model="form.data.phone"
                :error="form.errors.get('phone')">
        </input-text>

        <input-text
                label="Business Email"
                v-model="form.data.email"
                :error="form.errors.get('email')">
        </input-text>

        <div class="text-right">
            <button type="submit" class="btn btn-secondary" @submit.prevent="onSubmit">Save</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputText from "../inputs/InputText.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputText,
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
                    name: this.initialAccount.name,
                    business_name: this.initialAccount.business_name,
                    phone: this.initialAccount.phone,
                    email: this.initialAccount.email,
                }),
            };
        },

        methods: {
            /**
             * Submit the form.
             */
            onSubmit() {
                this.form.post('/account/contact').then(() => {
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
