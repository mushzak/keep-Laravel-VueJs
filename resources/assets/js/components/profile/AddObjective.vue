<template>
    <div>
        <form @submit.prevent="storeObjective" class="d-flex">
            <div style="flex-grow: 2" class="mr-2">
                <input-text-area
                        v-model="form.data.name"
                        :error="form.errors.get('name')"
                        label="Objective:">
                </input-text-area>
            </div>

            <div style="flex-grow: 1" class="mr-2">
                <input-date
                        v-model="form.data.due_at"
                        :error="form.errors.get('due_at')"
                        label="Due Date:">
                </input-date>
            </div>

            <input-submit label="Add objective" :disabled="this.form.isSubmitting" class="ml-2"></input-submit>
        </form>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputDate from "../inputs/InputDateDMH.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputDate,
            InputTextArea,
            InputSubmit,
        },

        props: {
            member: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    name: "",
                    due_at: "",
                })
            };
        },

        methods: {
            storeObjective() {
                this.form.post(`/members/${this.member.id}/objectives`).then(data => {
                    this.form.data.name = "";
                    this.form.data.due_at = "";

                    toastr.success("You have successfully created a new objective.")
                });
            },
        },
    };
</script>
