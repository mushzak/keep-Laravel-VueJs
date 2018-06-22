<template>
    <form class="align-items-center" @submit.prevent="onSubmit">
        <div class="card mb-3">
            <div class="card-body">
                <div v-if="questions.length">
                    <div v-for="(question, index) in questions">
                        <h4 v-text="question.content"></h4>

                        <input-text-area
                                :key="question.id"
                                label="Your response"
                                v-model="form.data.feedback[question.id]"
                                :error="form.errors.get(`feedback.${question.id}`)">
                        </input-text-area>

                        <div v-if="question.has_rating">
                            <input-number
                                    label="Your rating (1-10)"
                                    v-model="form.data.rating[question.id]"
                                    :error="form.errors.get(`feedback.${question.id}`)"
                                    value="1"
                                    min="1"
                                    max="10">
                            </input-number>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p>You should talk to your group facilitator and give them feedback.</p>
                </div>

                <input-submit label="Submit" :disabled="this.form.isSubmitting"></input-submit>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputNumber from "../inputs/InputNumber.vue";
    import InputTextArea from "../inputs/InputTextArea";
    import InputSubmit from "../inputs/InputSubmit";

    export default {
        components: {
            InputNumber,
            InputTextArea,
            InputSubmit,
        },

        props: {
            group: {
                type: Object,
                required: true,
            },

            member: {
                type: Object,
                required: true,
            },

            questions: {
                type: Array,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    feedback: {},
                    rating: {},
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.post(`/groups/${this.group.slug}/give-feedback`)
                    .then(data => {
                        window.location.href = data.redirect;
                    });
            },
        },
    }
</script>
