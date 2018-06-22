<template>
    <form class="d-flex align-items-center mb-3" @submit.prevent="updateQuestion">
        <div class="mr-3" style="flex-grow: 1;">
            <input-text-area
                    v-model="form.data.content"
                    :error="form.errors.get('content')">
            </input-text-area>

            <input-select
                    v-model="form.data.when_asked"
                    :options="options"
                    :error="form.errors.get('when_asked')">
            </input-select>

            <input-checkbox
                    label="Include rating?"
                    v-model="form.data.has_rating"
                    :error="form.errors.get('has_rating')">
            </input-checkbox>
        </div>

        <button type="submit" class="btn btn-sm btn-secondary mr-1">
            Update
        </button>

        <button type="button" class="btn btn-sm btn-outline-danger mr-1" @click.prevent="deleteQuestion">
            <i class="fa fa-trash-o"></i>
        </button>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSelect from "../inputs/InputSelect.vue";

    export default {
        components: {
            InputCheckbox,
            InputTextArea,
            InputSelect,
        },

        props: {
            question: {
                type: Object,
                required: true,
            },
        },

        watch: {
            question(value) {
                this.form.data.content = this.question.content;
            },
        },

        data() {
            return {
                form: new Form({
                    content: this.question.content,
                    when_asked: this.question.when_asked,
                    has_rating: this.question.has_rating,
                }),

                options: {
                    "onboarding": "Onboarding",
                    "review": "Spot review",
                    "exit": "Exit interview",
                    "inactive": "Inactive",
                },
            };
        },

        methods: {
            updateQuestion() {
                this.form.patch(`/group-configuration/feedback/${this.question.id}`);
            },

            deleteQuestion() {
                this.form.delete(`/group-configuration/feedback/${this.question.id}`);
            },
        },
    }
</script>
