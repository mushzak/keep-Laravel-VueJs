<template>
    <form class="d-flex align-items-center mb-3" @submit.prevent="updateExpectation">
        <div class="mr-2" style="flex-grow: 1;">
            <input-text-area
                    v-model="form.data.content"
                    :error="form.errors.get('content')"
                    class="mb-0">
            </input-text-area>
        </div>

        <button type="submit" class="btn btn-sm btn-secondary mr-1">
            Update
        </button>

        <button type="button" class="btn btn-sm btn-outline-danger mr-1" @click.prevent="deleteExpectation">
            <i class="fa fa-trash-o"></i>
        </button>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputTextArea from "../inputs/InputTextArea.vue";

    export default {
        components: {
            InputTextArea,
        },

        props: {
            expectation: {
                type: Object,
                required: true,
            },
        },

        watch: {
            expectation(value) {
                this.form.data.content = this.expectation.content;
            },
        },

        data() {
            return {
                form: new Form({
                    content: this.expectation.content,
                }),
            };
        },

        methods: {
            updateExpectation() {
                this.form.patch(`/group-configuration/about/${this.expectation.id}`);
            },

            deleteExpectation() {
                this.form.delete(`/group-configuration/about/${this.expectation.id}`);
            },
        },
    }
</script>
