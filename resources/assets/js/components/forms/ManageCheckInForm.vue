<template>
    <div class="card mb-3">
        <div class="card-header">Manage check-in settings</div>
        <div class="card-body">
            <input-select
                    id="check_in_interval"
                    label="How often do you want your users to access the site?"
                    v-model="form.data.check_in_interval"
                    :error="form.errors.get('check_in_interval')"
                    :options="checkInOptions">
            </input-select>

            <form @submit.prevent="onSubmit">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputSelect from "../inputs/InputSelect.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputSelect,
            InputSubmit,
        },

        props: {
            group: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                checkInOptions: {
                    0: "(do not enforce)",
                    1: "Once a day",
                    7: "Once a week",
                    14: "Once every two weeks",
                    30: "Once a month",
                    60: "Once every two months"
                },

                form: new Form({
                    check_in_interval: this.group.check_in_interval,
                })
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.post(`/groups/${this.group.slug}/check-in`)
                    .then(data => {
                        toastr.success("Your check in requirements has been updated successfully.");
                    });
            },
        },
    };
</script>