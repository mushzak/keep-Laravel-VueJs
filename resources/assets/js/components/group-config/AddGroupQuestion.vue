<template>
    <form class="d-flex align-items-center mb-3" @submit.prevent="storeQuestion">
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
            Add
        </button>

        <button type="button" class="btn btn-sm btn-secondary mr-1" @click.prevent="cancelQuestion">
            Cancel
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

        data() {
            return {
                form: new Form({
                    content: "",
                    has_rating: false,
                    when_asked: "onboarding",
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
            storeQuestion() {
                this.form.post(`/group-configuration/feedback`).then(() => {
                    this.$emit("added");

                    this.form.data.content = "";
                });
            },

            cancelQuestion() {
                this.$emit("cancel");

                this.form.data.content = "";
            },
        },
    };
</script>
