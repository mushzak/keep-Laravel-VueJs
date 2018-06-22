<template>
    <div>
        <form class="mb-3" @submit.prevent="onSubmit">
            <input-text
                    id="invite"
                    label="Invite"
                    placeholder="Email"
                    v-model="form.data.email"
                    :error="form.errors.get('email')">
            </input-text>

            <input-checkbox
                    label="Make group facilitator?"
                    v-model="form.data.is_facilitator"
                    :error="form.errors.get('is_facilitator')">
                <span class="help-block text-muted">Give new member your facilitator rights?</span>
            </input-checkbox>

            <input-checkbox
                    label="Make account manager?"
                    v-model="form.data.is_manager"
                    :error="form.errors.get('is_manager')">
                <span class="help-block text-muted">Move group to new member's payment account?</span>
            </input-checkbox>

            <input-submit label="Send invite" :disabled="form.isSubmitting"></input-submit>
        </form>

        <div class="list-group">
            <div class="list-group-item d-xs-block d-sm-flex align-items-center" v-for="invitation in invitations">
                <span class="mr-auto">
                    <div>{{ invitation.email }}</div>
                    <div class="text-muted">Will become facilitator on login</div>
                    <div class="text-muted">Will become account manager on login</div>
                </span>

                <button type="button" class="btn btn-sm btn-outline-danger mr-1" @click.prevent="deleteInvitation(invitation)">
                    <i class="fa fa-trash-o"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputText from "../inputs/InputText.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import TextDecorator from "../TextDecorator.vue";

    export default {
        components: {
            InputCheckbox,
            InputText,
            InputSubmit,
            TextDecorator,
        },

        props: {
            group: {
                type: Object,
                required: true,
            },

            invites: {
                type: Array,
                required: true,
            },
        },

        data() {
            return {
                invitations: [],

                form: new Form({
                    group_id: this.group.id,
                    email: '',
                    is_manager: false,
                    is_facilitator: false,
                })
            };
        },

        mounted() {
            this.invitations = this.invites.slice();

            // Broadcasting consumption
            window.Echo.private(`groups.${this.group.id}`)
                .listen("InviteCreated", (e) => {
                    toastr.success("An invite was created.");

                    this.invitations.push(e.invite);
                })
                .listen("InviteUpdated", (e) => {
                    toastr.success("An invite was updated.");

                    let index = this.invitations.findIndex(invitation => invitation.id == e.invite.id);
                    this.$set(this.invitations, index, e.invite);
                })
                .listen("InviteDeleted", (e) => {
                    toastr.success("An invite was deleted.");

                    let index = this.invitations.findIndex(invitation => invitation.id == e.invite.id);
                    this.invitations.splice(index, 1);
                });
        },


        methods: {
            onSubmit() {
                this.form.post(`/manage-members/invites`);
            },

            deleteInvitation(invitation) {
                this.form.delete(`/manage-members/invites/${invitation.id}`);
            }
        },
    };
</script>
