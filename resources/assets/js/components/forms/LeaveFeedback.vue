<template>
    <form @submit.prevent="onSubmit">
        <div class="card">
            <div class="card-header">Give Feedback</div>

            <div class="card-body">
                <table class="table table-striped" v-if="template.qnas.length > 0">
                    <tbody>
                    <tr v-for="(qna, index) in template.qnas" :key="qna.id">
                        <td v-text="qna.question"></td>
                        <td>
                            <div v-if="qna.question_type == 'star'">
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="1"> 1
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="2"> 2
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="3"> 3
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="4"> 4
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="5"> 5
                                </label>
                            </div>
                            <div v-else-if="qna.question_type == 'yes-no'">
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="yes"> Yes
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" v-model="form.data.new_qnas[qna.id]" value="no"> No
                                </label>
                            </div>
                            <div v-else>
                                <div class="text-danger">Unknown question type.</div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p v-else>
                    No questions asked.
                </p>

                <input-text-area
                        id="comments"
                        label="Comments"
                        :rows.number="3"
                        v-model="form.data.comments"
                        :error="form.errors.get('comments')">
                </input-text-area>
            </div>

            <div class="card-footer clearfix">
                <div class="pull-right">
                    <input-submit label="Save" :disabled="this.form.isSubmitting"></input-submit>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputText from "../inputs/InputText.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputText,
            InputTextArea,
            InputSubmit,
        },

        props: {
            action: {
                type: String,
                required: true,
            },

            member: {
                type: Object,
                required: true,
            },

            template: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    new_qnas: {},
                    comments: "",
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.post(this.action)
                    .then(data => {
                        toastr.success('Your feedback has been delivered successfully.');
                    });
            },
        },
    };
</script>
