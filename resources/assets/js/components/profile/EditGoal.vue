<template>
    <div>
        <div v-if="isEditingMode">
            <form @submit.prevent="updateGoal" class="d-flex">
                <div style="flex-grow: 1">
                    <input-text-area
                            v-model="form.data.name"
                            :error="form.errors.get('name')">
                    </input-text-area>
                </div>

                <input-submit label="Update goal" :disabled="this.form.isSubmitting" class="ml-2"></input-submit>
            </form>
        </div>
        <div class="d-xs-block d-sm-flex align-items-center" v-else>
            <p class="lead mb-0 mr-auto" v-if="goal">
                <text-decorator :text="goal.name"></text-decorator>
            </p>
            <p class="lead text-danger mb-0 mr-auto" v-else>
                No goal has been set.
            </p>

            <button type="button" class="btn btn-sm btn-outline-secondary mr-1"
                    @click.prevent="isEditingMode = !isEditingMode">
                <i class="fa fa-edit"></i>
            </button>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import TextDecorator from "../TextDecorator.vue";

    export default {
        components: {
            InputTextArea,
            InputSubmit,
            TextDecorator,
        },

        props: {
            member: {
                type: Object,
                required: true,
            },

            goal: {
                type: Object,
            },
        },

        data() {
            return {
                isEditingMode: false,

                form: new Form({
                    name: this.goal ? this.goal.name : '',
                }),
            };
        },

        methods: {
            updateGoal() {
                this.form.patch(`/members/${this.member.id}/goals/${this.goal.id}`)
                    .then(data => {
                        this.isEditingMode = false;

                        toastr.success("Your goal has been updated successfully.");
                    });
            },
        },
    }
</script>
