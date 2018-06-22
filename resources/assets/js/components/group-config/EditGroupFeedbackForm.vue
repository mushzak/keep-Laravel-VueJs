<template>
    <div>
        <group-question
                v-for="question in questions"
                :key="question.id"
                :question="question">
        </group-question>

        <div v-if="! questions.length">
            <p class="text-center">You currently have no group questions set.</p>
        </div>

        <add-group-question
                v-if="isAddingNewQuestion"
                @added="isAddingNewQuestion = false"
                @cancel="isAddingNewQuestion = false">
        </add-group-question>

        <div class="text-right">
            <button type="button" class="btn btn-secondary" @click.prevent="isAddingNewQuestion = !isAddingNewQuestion">Add</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </div>
</template>

<script>
    import AddGroupQuestion from "./AddGroupQuestion.vue";
    import GroupQuestion from "./GroupQuestion.vue";

    export default {
        components: {
            AddGroupQuestion,
            GroupQuestion,
        },

        props: {
            initialGroup: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isAddingNewQuestion: false,
                questions: [],
            };
        },

        mounted() {
            this.questions = this.initialGroup.questions.slice();

            // Broadcasting consumption
            window.Echo.private(`groups.${this.initialGroup.id}`)
                .listen("QuestionCreated", (e) => {
                    toastr.success("An question was created.");

                    this.questions.push(e.question);
                })
                .listen("QuestionUpdated", (e) => {
                    toastr.success("An question was updated.");

                    let index = this.questions.findIndex(question => question.id == e.question.id);
                    this.$set(this.questions, index, e.question);
                })
                .listen("QuestionDeleted", (e) => {
                    toastr.success("An question was deleted.");

                    let index = this.questions.findIndex(question => question.id == e.question.id);
                    this.questions.splice(index, 1);
                });
        },

        methods: {
            /**
             * Cancel changes made to this page.
             */
            cancelChanges() {
                window.location.reload();
            },
        },
    }
</script>
