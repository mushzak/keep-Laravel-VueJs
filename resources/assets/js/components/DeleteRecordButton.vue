<template>
    <a href="#" @click.prevent="onClick">
        <slot></slot>
    </a>
</template>

<script>
    import Form from "../utilities/Form";

    export default {
        props: {
            action: {
                required: true,
            },

            title: {
                type: String,
                default: 'Want to delete this?',
            },

            message: {
                type: String,
                default: "Are you sure you want to delete this?  You will not be able to reverse this action!",
            },
        },

        data() {
            return {
                form: new Form({}),
            };
        },

        methods: {
            onClick(event) {
                swal({
                    title: this.title,
                    text: this.message,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    confirmButtonClass: 'btn btn-danger',
                    cancelButtonClass: 'btn btn-secondary',
                })
                    .then(() => {
                        // Delete it.
                        this.form.delete(this.action)
                            .then(data => {
                                window.location.href = data.redirect;
                            });
                    });
            },
        },
    }

</script>
