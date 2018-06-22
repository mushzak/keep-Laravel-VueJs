<template>
    <div>
        <manage-group
                v-for="group in groups"
                :account_members="account_members"
                :key="group.id"
                :group="group">
        </manage-group>

        <div v-if="! groups.length">
            <p class="text-center">You currently have no groups added within this account.</p>
        </div>

        <add-group-to-account
                v-if="isAddingNewGroup"
                :account_members="account_members"
                @added="isAddingNewGroup = false"
                @cancel="isAddingNewGroup = false">
        </add-group-to-account>

        <div class="text-right">
            <button type="button" class="btn btn-secondary" @click.prevent="isAddingNewGroup = !isAddingNewGroup">New</button>
          
        </div>
    </div>
</template>

<script>
    import AddGroupToAccount from "./AddGroupToAccount.vue";
    import ManageGroup from "./ManageGroup.vue";

    export default {
        components: {
            AddGroupToAccount,
            ManageGroup,
        },

        props: {
            initialAccount: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isAddingNewGroup: false,
                groups: [],
                account_members: [],
            };
        },

        mounted() {
            this.groups = this.initialAccount.groups.slice();
            this.account_members = this.initialAccount.members;
            // Broadcasting consumption
            window.Echo.private(`accounts.${this.initialAccount.id}`)
                .listen("GroupCreated", (e) => {
                    toastr.success("An group was created.");

                    this.groups.push(e.group);
                })
                .listen("GroupUpdated", (e) => {
                    toastr.success("An group was updated.");

                    let index = this.groups.findIndex(group => group.id == e.group.id);
                    this.$set(this.groups, index, e.group);
                })
                .listen("GroupDeleted", (e) => {
                    toastr.success("An group was deleted.");

                    let index = this.groups.findIndex(group => group.id == e.group.id);
                    this.groups.splice(index, 1);
                });
        },

        methods: {
            /**
             * Cancel changes made to this page.
             */
            cancelChanges() {
                window.location.reload();
            },
        },
    }
</script>
