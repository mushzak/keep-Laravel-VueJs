<template>
    <form class="d-flex align-items-center mb-3" @submit.prevent="updateGroup">
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
                    :options="accountUsers"
                    :error="form.errors.get('facilitator_id')"
                    class="mb-0">
            </input-select>
        </div>

        <button type="submit" class="btn btn-sm btn-secondary mr-1">
            Update
        </button>

        <button type="button" class="btn btn-sm btn-outline-danger mr-1" @click.prevent="deleteGroup">
            <i class="fa fa-trash-o"></i>
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

        props: {
            group: {
                type: Object,
                required: true,
            },

            account_members:{
                    type:Array,
                    required:true,},
        },

        computed:{
            accountUsers: function(){
 
                let temp_object={}
                this.account_members.forEach( 
                        function(member){
                            temp_object[member.user.id]=member.user.name;
                        });
                return temp_object;
            },

        },

        watch: {
            group(value) {
                this.form.data.name = this.group.name;
                this.form.data.facilitator_id = this.group.facilitator_id;
            },
        },

        data() {
            return {
                form: new Form({
                    name: this.group.name,
                    facilitator_id: this.group.facilitator_id,
                }),
            };
        },

        methods: {
            updateGroup() {
                this.form.patch(`/account/groups/${this.group.slug}`);
            },

            deleteGroup() {
                swal({
                    title: "Want to delete this?",
                    text: "Are you sure you want to delete this reply?  You will not be able to reverse this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Confirm",
                    cancelButtonText: "Cancel",
                    confirmButtonClass: "btn btn-danger",
                    cancelButtonClass: "btn btn-secondary",
                }).then(() => {
                    this.form.delete(`/account/groups/${this.group.slug}`);
                });
            },
        },
    }
</script>
