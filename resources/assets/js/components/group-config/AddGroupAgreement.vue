<template>
    <form class="d-flex align-items-center mb-3" @submit.prevent="storeAgreement">
        <div class="mr-2" style="flex-grow: 1;">
            <input-text-area
                    v-model="form.data.content"
                    :error="form.errors.get('content')"
                    class="mb-0">
            </input-text-area>
        </div>

        <button type="submit" class="btn btn-sm btn-secondary mr-1">
            Add
        </button>

        <button type="button" class="btn btn-sm btn-secondary mr-1" @click.prevent="cancelAgreement">
            Cancel
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

        data() {
            return {
                form: new Form({
                    content: "",
                }),
            };
        },

        methods: {
            storeAgreement() {
                this.form.post(`/group-configuration/agreements`).then(() => {
                    this.$emit('added');

                    this.form.data.content = "";
                });
            },

            cancelAgreement() {
                this.$emit('cancel');

                this.form.data.content = "";
            },
        },
    }
</script>
