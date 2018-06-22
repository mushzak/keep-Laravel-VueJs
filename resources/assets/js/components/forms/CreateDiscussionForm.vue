<template>
    <form @submit.prevent="storeDiscussion">
        <input-text-area label="Title" v-model="form.data.title" :error="form.errors.get('title')"></input-text-area>

        <input-text-area label="Body" v-model="form.data.body" :error="form.errors.get('body')"></input-text-area>

        <input-checkbox label="Is this urgent?" v-model="form.data.is_urgent" :error="form.errors.get('is_urgent')">
            <span class="form-text text-muted">
                This will notify everyone in the discussion.
            </span>
        </input-checkbox>

        <input-submit label="Send message" :disabled="this.form.isSubmitting"></input-submit>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox";
    import InputTextArea from "../inputs/InputTextArea";
    import InputSubmit from "../inputs/InputSubmit";

    export default {
        components: {
            InputCheckbox,
            InputTextArea,
            InputSubmit,
        },

        props: {
            action: {
                type: String,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    title: "",
                    body: "",
                    is_urgent: false,
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            storeDiscussion() {
                this.form.post(this.action).then(data => {
                    window.location.href = data.redirect;
                });
            },
        },
    };
</script>
