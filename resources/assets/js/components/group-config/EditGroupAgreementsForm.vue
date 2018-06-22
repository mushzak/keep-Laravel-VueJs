<template>
    <div>
        <group-agreement
                v-for="agreement in agreements"
                :key="agreement.id"
                :agreement="agreement">
        </group-agreement>

        <div v-if="! agreements.length">
            <p class="text-center">You currently have no group agreements set.</p>
        </div>

        <add-group-agreement
                v-if="isAddingNewAgreement"
                @added="isAddingNewAgreement = false"
                @cancel="isAddingNewAgreement = false">
        </add-group-agreement>

        <div class="text-right">
            <button type="button" class="btn btn-secondary" @click.prevent="isAddingNewAgreement = !isAddingNewAgreement">Add</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </div>
</template>

<script>
    import AddGroupAgreement from "./AddGroupAgreement.vue";
    import GroupAgreement from "./GroupAgreement.vue";

    export default {
        components: {
            AddGroupAgreement,
            GroupAgreement,
        },

        props: {
            initialGroup: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isAddingNewAgreement: false,
                agreements: [],
            };
        },

        mounted() {
            this.agreements = this.initialGroup.agreements.slice();

            // Broadcasting consumption
            window.Echo.private(`groups.${this.initialGroup.id}`)
                .listen("AgreementCreated", (e) => {
                    toastr.success("An agreement was created.");

                    this.agreements.push(e.agreement);
                })
                .listen("AgreementUpdated", (e) => {
                    toastr.success("An agreement was updated.");

                    let index = this.agreements.findIndex(agreement => agreement.id == e.agreement.id);
                    this.$set(this.agreements, index, e.agreement);
                })
                .listen("AgreementDeleted", (e) => {
                    toastr.success("An agreement was deleted.");

                    let index = this.agreements.findIndex(agreement => agreement.id == e.agreement.id);
                    this.agreements.splice(index, 1);
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
