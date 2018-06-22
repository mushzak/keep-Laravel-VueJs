<template>
    <form class="d-flex align-items-center mb-3" @submit.prevent="storeGroup">
        <div class="mr-1" style="flex-grow: 1;">
            <input-text
                    v-model="form.data.name"
                    :error="form.errors.get('name')"
                    class="mb-0">
            </input-text>
        </div>

        <div class="mr-1" style="flex-grow: 1;">
            <input-select
                    v-model="form.data.facilitator_id"
                    :options="accountMembers"
                    :error="form.errors.get('facilitator_id')"
                    class="mb-0">
            </input-select>
        </div>

        <button type="submit" class="btn btn-sm btn-secondary mr-1">
            Add
        </button>

        <button type="button" class="btn btn-sm btn-secondary mr-1" @click.prevent="cancelGroup">
            Cancel
        </button>
    </form>
</template>

<script>
    import Form from "../../utilities/Form";
    import InputText from "../inputs/InputText.vue";
    import InputSubmit from "../inputs/InputSubmit.vue";
    import InputSelect from "../inputs/InputSelect.vue";

    export default {
        components: {
            InputText,
            InputSubmit,
            InputSelect,
        },

        props:{
            account_members:{
                    type:Array,
                    required:true,},
        },

        computed:{
            accountMembers: function(){
 
                let temp_object={}
                this.account_members.forEach( 
                        function(member){
                            temp_object[member.id]=member.user.name;
                        });
                return temp_object;
            }
        },

        data() {
            return {
                form: new Form({
                    name: "",
                }),
            };
        },

        methods: {
            storeGroup() {
                this.form.post(`/account/groups`).then(() => {
                    this.$emit('added');

                    this.form.data.content = "";
                });
            },

            cancelGroup() {
                this.$emit('cancel');

                this.form.data.content = "";
            },

        },
    }
</script>
