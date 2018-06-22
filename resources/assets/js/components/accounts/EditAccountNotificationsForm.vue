<template>
    <div>

        <div class="col-md-12">
            <div class="col-md-8">
                <h2> Flag Members If Needed</h2>
                <label class="switch-notification-settings">
                    <input class="switch-notification-input" type="checkbox" v-model="form.data.checkedFlagMembers">
                    <span @click.prevent="switchNotifyAccount(1)" class="slider-notification round-notification"></span>
                </label>
            </div>

            <div class="col-md-8">
               <h2> Notify Active Participants Of Meeting</h2>
                <label class="switch-notification-settings">
                    <input class="switch-notification-input" type="checkbox" v-model="form.data.checkedParticipantsMeeting">
                    <span @click.prevent="switchNotifyAccount(2)" class="slider-notification round-notification"></span>
                </label>
            </div>
        </div>

    </div>
</template>
<script>

    import Form from "../../utilities/Form";
    import InputCheckbox from "../inputs/InputCheckbox.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputCheckbox,
            InputSubmit,
        },

        props: {
            initialAccount: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                form: new Form({
                    checkedParticipantsMeeting:false,
                    checkedFlagMembers:false,
                }),

            };
        },

        methods: {
            /**
             * Cancel changes made to this page.
             */
            cancelChanges() {
                window.location.reload();
            },

            switchNotifyAccount(id){
                switch (id) {
                    case 1:
                        this.form.data.checkedFlagMembers = !this.form.data.checkedFlagMembers;
                        break;
                    case 2:
                        this.form.data.checkedParticipantsMeeting = !this.form.data.checkedParticipantsMeeting;
                        break;
                }

                this.form.post('/account/notifications/update').then(() => {
                    toastr.success("Your account settings have been updated successfully.")
                });
            }
        },
    }
</script>
