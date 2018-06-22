<template>
    <div class="card mb-2">
        <div class="card-body">
            <div class="media row ">
                <div class="col-1">
                    <a href="#!" class="text-info text-center align-self-top">
                        <img :src="`/storage/${member.personal_avatar}`"
                             :alt="member.user.name"
                             class="img-thumbnail rounded-circle "
                             style="height:50px"
                             v-if="member.personal_avatar"/>

                        <div class="img-thumbnail mx-auto d-flex flex-column justify-content-center "
                             style="height:50px"
                             v-else>
                            <span class="fa fa-2x fa-user"></span>
                        </div>
                    </a>
                </div>

                <div class="col-sm-3 col-lg-4">
                    <h4> {{member.user.name}}</h4>
                    <div v-if="member.user.id == member.group.facilitator_id">
                        Facilitator
                    </div>
                    <div v-else>
                        Member
                    </div>
                </div>

                <div class="col-sm-3">
                    <div>
                        <div v-if="member.can_edit_all">
                            Has global edit permissions
                        </div>
                        <div v-else>
                            Can edit self only
                        </div>
                    </div>
                    <div>
                        <div v-if="member.can_view_all">
                            Has global viewing permissions
                        </div>
                        <div v-else>
                            Can view group only
                        </div>
                    </div>
                    <div v-if="member.onboarding_step">
                        Currently onboarding
                    </div>
                </div>

                <div class="col-sm-4 col-lg-3">
                    <form @submit.prevent="onSubmit">
                        <input-select
                                v-model="form.data.status"
                                :options="options"
                                :error="form.errors.get('status')"
                                @input="updateRecord">
                        </input-select>
                    </form>
                </div>

                <div class="col-1">
                    <a href="#" class="btn btn-sm btn-outline-danger" @click.prevent="deleteRecord">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputSelect from "../inputs/InputSelect.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import TextDecorator from "../TextDecorator.vue";

    export default {
        components: {
            InputSelect,
            InputSubmit,
            TextDecorator,
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
                    status: this.member.status,
                }),

                options: {
                    "active": "Active",
                    "inactivated": "Inactivated",
                },
            };
        },

        methods: {
            /**
             * Update this reply.
             */
            updateRecord() {
                this.form.patch(`/manage-members/${this.member.id}`)
                    .then(data => {
                        toastr.success("The member has been updated successfully.");
                    });
            },

            /**
             * Update this reply.
             */
            deleteRecord() {
                swal({
                    title: "Want to delete this?",
                    text: "Are you sure you want to delete this member?  You will not be able to reverse this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-secondary",
                }).then(() => {
                    axios.delete(`/manage-members/${this.member.id}`)
                        .then(data => {
                            window.location.reload();
                        });
                });
            },
        },
    };
</script>
