<template>
    <form @submit.prevent="onSubmit" @change="form.markAsChanged()" id="update-big-picture">
        <div class="card mb-3">
            <div class="card-header">Big Picture</div>
            <div class="card-body">
                <input-text-area
                        id="vision"
                        label="Vision"
                        v-model="form.data.vision"
                        :error="form.errors.get('vision')">
                </input-text-area>

                <input-text-area
                        id="values"
                        label="Values"
                        v-model="form.data.values"
                        :error="form.errors.get('values')">
                </input-text-area>

                <input-text-area
                        id="mission"
                        label="Mission"
                        v-model="form.data.mission"
                        :error="form.errors.get('mission')">
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
            },

        },

        data() {
            return {
                form: new Form({
                    vision: this.member.vision,
                    values: this.member.values,
                    mission: this.member.mission,
                }),

                flags: this.member.open_flags,
            };
        },

        computed:{
            needAffirm: function() {
                let return_value=0;
                this.flags.forEach(function(flag){
                    if(flag.type=="updated-big-picture" && flag.resolved_at==null){
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

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.form.data.vision = e.member.vision;
                    this.form.data.values = e.member.values;
                    this.form.data.mission = e.member.mission;
                })
                .listen("FlagUpdated", (e) => {
                    console.log('A flag for this member was updated.');

                    let flagIndex = this.flags.findIndex(flag => flag.id == e.flag.id);

                    this.$set(this.flags, flagIndex, e.flag);

                });;
        },

        methods: {
            /**
             * Triggers when the form has submitted.
             */
            onSubmit() {
                this.form.patch(`/members/${this.member.id}/big-picture`)
                    .then(data => {
                        toastr.success("Your big picture has been updated successfully.");
                    });
            },

        },
    };
</script>
