<template>
    <div class="card border-danger mb-3">
        <div class="card-header">Advance current process</div>
        <div class="card-body">
            <p>This will advance the group to the next process.</p>

            <form @submit.prevent="onSubmit">
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Advance</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
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
                finishProcessForm: new Form({
                    //
                })
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.finishProcessForm.post(`/groups/${this.group.slug}/advance-process`)
                    .then(data => {
                        toastr.success("Your action plan has been finished successfully.");

                        this.refresh();
                    });
            },
        },
    };
</script>