<template>
    <div class="card">
            <div class="card-body">
                <div class="align-items-center">
                        <div class="mb-3" v-if="initialGroup.avatar">
                            <img :src="'/storage/' + initialGroup.avatar" class="img-fluid img-thumbnail rounded" style="max-height: 200px; max-width: 200px" />
                        </div>
                        <div class="mb-3" v-else>
                            [no image uploaded]
                        </div>
                </div>
                <b>Name</b>
                <p><text-decorator :text="name"></text-decorator></p>
                <b>Purpose</b>
                <p><text-decorator :text="purpose"></text-decorator></p>
                <b>Slogan</b>
                <p><text-decorator :text="slogan"></text-decorator></p>
                <b>Location</b>
                <p><text-decorator :text="location"></text-decorator></p>
                <b>Contact</b>
                <p><text-decorator :text="contact"></text-decorator></p>
                <b>Description</b>
                <p><text-decorator :text="description"></text-decorator></p>
            </div>
        </div>
</template>

<script>

    export default {
        components: {

        },

        props: {
            initialGroup: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                    avatar: this.initialGroup.avatar,
                    name: this.initialGroup.name,
                    purpose: this.initialGroup.purpose,
                    slogan: this.initialGroup.slogan,
                    location: this.initialGroup.location,
                    contact: this.initialGroup.contact,
                    description: this.initialGroup.description,
            };
        },

        methods: {

        },
    }
</script>
