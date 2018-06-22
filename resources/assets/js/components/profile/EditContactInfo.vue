<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()" id="update-contact-info">
        <div class="card mb-3">
            <div class="card-header">Contact Information</div>
            <div class="card-body">
                <input-text
                        id="email"
                        label="Email"
                        v-model="form.data.email"
                        :error="form.errors.get('email')">
                </input-text>

                <input-text
                        id="phone_1"
                        label="Phone"
                        v-model="form.data.phone_1"
                        :error="form.errors.get('phone_1')">
                </input-text>

                <input-text
                        id="phone_2"
                        label="Phone (#2)"
                        v-model="form.data.phone_2"
                        :error="form.errors.get('phone_2')">
                </input-text>

                <input-text
                        id="other"
                        label="Other POCs"
                        v-model="form.data.other"
                        :error="form.errors.get('other')">
                </input-text>
            </div>

            <div class="card-footer text-right">
                <input-submit :label="form.hasChanges ? 'Save' : 'Save'" :disabled="form.isSubmitting"></input-submit>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputText from "../inputs/InputText.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputText,
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
                    email: this.member.email,
                    other: this.member.other,
                    phone_1: this.member.phone_1,
                    phone_2: this.member.phone_2,
                }),
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.form.data.email = e.member.email;
                    this.form.data.other = e.member.other;
                    this.form.data.phone_1 = e.member.phone_1;
                    this.form.data.phone_2 = e.member.phone_2;
                });
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/members/${this.member.id}/contact`)
                    .then(data => {
                        toastr.success("Your contact information has been updated successfully.");
                    });
            },
        },
    };
</script>