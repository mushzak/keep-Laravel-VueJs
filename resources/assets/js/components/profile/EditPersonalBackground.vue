<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()" id="update-personal-background">
        <div class="card mb-3">
            <div class="card-header">Personal Background</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-6 col-sm-2">
                        <div v-if="displayed_personal_avatar">
                            <img :src="'/storage/' + displayed_personal_avatar" class="img-fluid rounded" :alt="member.user.name">
                        </div>
                        <div v-else>
                            [no image uploaded]
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <input-text-area
                                id="personal_bio"
                                label="Bio"
                                v-model="form.data.personal_bio"
                                :error="form.errors.get('personal_bio')">
                        </input-text-area>

                        <input-file
                                id="personal_avatar"
                                label="Change personal photo"
                                @input= " (file) => {form.data.personal_avatar = file} " 
                                :error="form.errors.get('personal_avatar')">
                        </input-file>
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <input-submit :label="form.hasChanges ? 'Save' : 'Save'" :disabled="form.isSubmitting"></input-submit>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputFile from "../inputs/InputFile.vue";
    import InputText from "../inputs/InputText.vue";
    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputFile,
            InputText,
            InputTextArea,
            InputSubmit,
        },

        props: {
            member: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                form: new Form({
                    personal_bio: this.member.personal_bio,
                    personal_avatar: null,
                }),
                displayed_personal_avatar:this.member.personal_avatar,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.form.data.personal_bio = e.member.personal_bio;
                    this.displayed_personal_avatar = e.member.personal_avatar;
                });
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/members/${this.member.id}/personal-background`)
                    .then(data => {
                        toastr.success('Your personal background has been updated successfully.');
                    });
            },

        },
    };
</script>
