<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()" id="update-personal-motivation">
        <div class="card mb-3">
            <div class="card-header">Personal Motivation</div>
            <div class="card-body">
                <input-text-area
                        id="why"
                        label="Why"
                        v-model="form.data.why"
                        :error="form.errors.get('why')">
                </input-text-area>

                <input-text-area
                        id="consequences"
                        label="Consequences"
                        v-model="form.data.consequences"
                        :error="form.errors.get('consequences')">
                </input-text-area>
            </div>

            <div class="card-footer d-flex align-items-center">
                <div class="ml-auto">
                    <input-submit :classes="affirmClass" :label="form.hasChanges ? 'Save' : 'Affirm'" :disabled="form.isSubmitting"></input-submit>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";

    import InputTextArea from "../inputs/InputTextArea.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";

    export default {
        components: {
            InputTextArea,
            InputSubmit,
        },

        props: {
            member: {
                type: Object,
                required: true,
            }
        },

        computed:{
            needAffirm() {
                let return_value=0;
                this.flags.forEach(function(flag){
                    if(flag.type=="updated-personal-motivation" && flag.resolved_at==null){
                        return_value=1;
                    }
                });
                return return_value             
            },   

            affirmClass() {
                let return_value=["btn-secondary"];
                if(this.needAffirm==1){
                    return_value= ["btn-primary"];
                }
                return return_value         
            }, 
        },

        data() {
            return {
                form: new Form({
                    why: this.member.why,
                    consequences: this.member.consequences,
                }),

                flags:this.member.open_flags,
            };
        },


        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.form.data.why = e.member.why;
                    this.form.data.consequences = e.member.consequences;
                })
                .listen("FlagUpdated", (e) => {
                    console.log('A flag for this member was updated.');
                    let flagIndex = this.flags.findIndex(flag => flag.id == e.flag.id);

                    this.$set(this.flags, flagIndex, e.flag);

                });

        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/members/${this.member.id}/personal-motivation`)
                    .then(data => {
                        toastr.success('Your personal motivations have been updated successfully.');
                    });
            },
        },
    };
</script>
