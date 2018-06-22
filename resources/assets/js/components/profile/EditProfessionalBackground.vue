<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()" id="update-professional-background">
        <div class="card mb-3">
            <div class="card-header">Professional Background</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-6 col-sm-2">
                        <div v-if="displayed_business_avatar">
                            <img :src="'/storage/' + displayed_business_avatar" class="img-fluid rounded" :alt="form.data.company_name">
                        </div>
                        <div v-else>
                            [no image uploaded]
                        </div>
                    </div>

                    <div class="col-sm-10">
                        <input-text
                                id="company_name"
                                label="Company Name"
                                v-model="form.data.company_name"
                                :error="form.errors.get('company_name')">
                        </input-text>

                        <input-text-area
                                id="business_bio"
                                label="Company Bio"
                                v-model="form.data.business_bio"
                                :error="form.errors.get('business_bio')">
                        </input-text-area>

                        <input-file
                                id="business_avatar"
                                label="Change business photo"
                                @input="(file) => { form.data.business_avatar = file }"
                                :error="form.errors.get('business_avatar')">
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
                    company_name: this.member.company_name,
                    business_bio: this.member.business_bio,
                    business_avatar: null,
                }),
                displayed_business_avatar:this.member.business_avatar,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.form.data.company_name = e.member.company_name;
                    this.form.data.business_bio = e.member.business_bio;
                    this.displayed_business_avatar = e.member.business_avatar;
                });
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/members/${this.member.id}/professional-background`)
                    .then(data => {
                        toastr.success('Your professional background has been updated successfully.');
                    });
            },
        },
    };
</script>
