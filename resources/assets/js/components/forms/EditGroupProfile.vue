<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-sm">
                        <div class="mb-3" v-if="initialGroup.avatar">
                            <img :src="'/storage/' + initialGroup.avatar" class="img-fluid img-thumbnail rounded" style="max-height: 200px; max-width: 200px" />
                        </div>
                        <div class="mb-3" v-else>
                            [no image uploaded]
                        </div>
                    </div>
                    <div class="col-sm">
                        <input-file
                                id="avatar"
                                label="Change group avatar"
                                @input="(file) => { form.data.avatar = file }"
                                :error="form.errors.get('avatar')">
                        </input-file>
                    </div>
                </div>

                <input-text
                        id="name"
                        label="Name"
                        v-model="form.data.name"
                        :error="form.errors.get('name')">
                </input-text>

                <input-text-area
                        id="purpose"
                        label="Purpose"
                        v-model="form.data.purpose"
                        :error="form.errors.get('purpose')">
                </input-text-area>

                <input-text-area
                        id="slogan"
                        label="Slogan"
                        v-model="form.data.slogan"
                        :error="form.errors.get('slogan')">
                </input-text-area>

                <input-text-area
                        id="location"
                        label="Location"
                        v-model="form.data.location"
                        :error="form.errors.get('location')">
                </input-text-area>

                <input-text-area
                        id="contact"
                        label="Contact"
                        v-model="form.data.contact"
                        :error="form.errors.get('contact')">
                </input-text-area>

                <input-text-area
                        id="description"
                        label="Description"
                        v-model="form.data.description"
                        :error="form.errors.get('description')">
                </input-text-area>
            </div>

            <div class="card-footer text-right">
                <input-submit :label="form.hasChanges ? 'Save' : 'Save'" :disabled="form.isSubmitting"></input-submit>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form"

    import InputFile from "../inputs/InputFile.vue";
    import InputText from "../inputs/InputText";
    import InputTextArea from "../inputs/InputTextArea";
    import InputSubmit from "../inputs/InputSubmit";

    export default {
        components: {
            InputFile,
            InputText,
            InputTextArea,
            InputSubmit,
        },

        props: {
            initialGroup: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                form: new Form({
                    name: this.initialGroup.name,
                    purpose: this.initialGroup.purpose,
                    slogan: this.initialGroup.slogan,
                    location: this.initialGroup.location,
                    contact: this.initialGroup.contact,
                    description: this.initialGroup.description,
                }),
            };
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/groups/${this.initialGroup.slug}`)
                    .then(data => {
                        window.location.reload();
                    }).catch(error => {
                        toastr.error(error.message);
                    });
            },
        },
    }
</script>
