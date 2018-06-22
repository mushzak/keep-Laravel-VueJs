<template>
    <div class="card">
        <div class="card-body">
            <div class="media d-block d-md-flex">
                <div class="d-flex flex-column mb-3 mb-md-0">
                    <a href="#!" class="text-info text-center align-self-top">
                        <img :src="`/storage/${reply.author.personal_avatar}`"
                             :alt="reply.author.user.name"
                             class="img-thumbnail rounded-circle mb-3"
                             style="width: 30px; height: 30px"
                             v-if="reply.author.personal_avatar"/>

                        <div class="img-thumbnail mx-auto d-flex flex-column justify-content-center mb-3"
                             style="width: 30px; height: 30px"
                             v-else>
                            <span class="fa fa-2x fa-user"></span>
                        </div>
                    </a>

                    <div class="text-center align-self-bottom" v-if="reply.author.user.id === authUserId || facilitatorId === authUserId">
                        <a href="#" class="btn btn-sm btn-outline-secondary" @click.prevent="updateRecordButton">
                            <i class="fa fa-edit"></i>
                        </a>

                        <a href="#" class="btn btn-sm btn-outline-secondary" @click.prevent="deleteRecord">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="media-body align-self-center ml-md-4">
                    <p class="text-muted">
                        <span v-if="reply.author">{{ reply.author.user.name }}</span>
                        (<date-format :value="reply.created_at" format="MMM DD, h:mm a"></date-format>)
                    </p>
                    <div v-if="isEditingMode">
                        <form @submit.prevent="updateRecord">
                            <input-text-area
                                    v-model="form.data.body"
                                    :error="form.errors.get('body')">
                            </input-text-area>

                            <input-submit label="Update reply" :disabled="this.form.isSubmitting"></input-submit>
                        </form>
                    </div>
                    <div v-else>
                        <text-decorator :text="reply.body" :should-add-mentions="true" :members="members" :group="group"></text-decorator>
                    </div>
                </div>
            </div>
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
            discussion: {
                type: Object,
                required: true,
            },

            reply: {
                type: Object,
                required: true,
            },

            group: {
                type: Object,
               // required: true,
            },

            members: {
                type: Array,
                required: true,
            },
            authUserId: {
                type: Number,
             //   required: true,
            },
            facilitatorId: {
                type: Number,
             //   required: true,
            },
        },

        data() {
            return {
                isEditingMode: false,

                form: new Form({
                    body: this.reply.body,
                }),
            };
        },

        methods: {
            /**
             * Update this reply.
             */
            updateRecord() {
                this.form.patch(`/replies/${this.reply.id}`)
                    .then(data => {
                        this.isEditingMode = false;

                        toastr.success('The reply has been updated successfully.');
                    });
            },

            updateRecordButton(){
                console.log(this.reply.body);
                this.form.data.body = this.reply.body;
                this. isEditingMode = !this.isEditingMode
            },

            /**
             * Prompt to delete this discussion reply.
             */
            deleteRecord() {
                swal({
                    title: "Want to delete this?",
                    text: "Are you sure you want to delete this reply?  You will not be able to reverse this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-secondary",
                }).then(() => {
                    axios.delete(`/replies/${this.reply.id}`)
                        .then(data => {
                            toastr.success('The reply has been deleted successfully.');
                        });
                });
            },
        },
    };
</script>
