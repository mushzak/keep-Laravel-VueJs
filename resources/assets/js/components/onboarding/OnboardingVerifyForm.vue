<template>
    <form @submit.prevent="onSubmit">
        <input-text label="Name" v-model="form.data.name" :error="form.errors.get('name')"></input-text>
        <input-email label="Email" v-model="form.data.email" :error="form.errors.get('email')">
            <p class="form-text text-muted">This is the email that will be made public to your fellow group members.  Your notifications will still be sent to <b>{{ member.user.email }}</b></p>
        </input-email>
        <input-checkbox label="Do you use text messaging?" v-model="usesTextMessaging"></input-checkbox>

        <div v-if="usesTextMessaging">
            <input-text label="Text Number" v-model="form.data.text_phone" :error="form.errors.get('text_phone')"></input-text>
        </div>

        <input-checkbox label="Enable 2 Factor Authentication?" v-model="form.data.is_using_2fa" :error="form.errors.get('is_using_2fa')"></input-checkbox>

        <div class="d-flex justify-content-center">
            <input-submit label="Save and Continue" :class="['btn-outline-secondary', 'mr-3']" :disabled="this.form.isSubmitting"></input-submit>
            <button type="button" class="btn btn-outline-secondary">Cancel</button>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox";
    import InputText from "../inputs/InputText";
    import InputEmail from "../inputs/InputEmail";
    import InputSubmit from "../inputs/InputSubmit";

    export default {
        components: {
            InputCheckbox,
            InputText,
            InputEmail,
            InputSubmit,
        },

        props: {
            member: {
                type: Object,
                required: true,
            },
        },

        watch: {
            /**
             * Unset the text phone value if the user is not using text messaging.
             */
            usesTextMessaging(value) {
                if (!value)
                    this.form.data.text_phone = "";
            },
        },

        data() {
            return {
                usesTextMessaging: Boolean(this.member.user.text_phone),

                form: new Form({
                    name: this.member.user.name,
                    email: this.member.email,
                    text_phone: this.member.user.text_phone,
                    is_using_2fa: this.member.user.is_using_2fa,
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.post(`/onboarding/verify`)
                    .then(data => {
                        window.location.href = data.redirect;
                    });
            },
        },
    }
</script>
