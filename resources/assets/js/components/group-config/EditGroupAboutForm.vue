<template>
    <div>
        <group-expectation
                v-for="expectation in expectations"
                :key="expectation.id"
                :expectation="expectation">
        </group-expectation>

        <div v-if="! expectations.length">
            <p class="text-center">You currently have no group expectations set.</p>
        </div>

        <add-group-expectation
                v-if="isAddingNewExpectation"
                @added="isAddingNewExpectation = false"
                @cancel="isAddingNewExpectation = false">
        </add-group-expectation>

        <div class="text-right">
            <button type="button" class="btn btn-secondary" @click.prevent="isAddingNewExpectation = !isAddingNewExpectation">Add</button>
            <button type="button" class="btn btn-secondary" @click.prevent="cancelChanges">Cancel</button>
        </div>
    </div>
</template>

<script>
    import AddGroupExpectation from "./AddGroupExpectation.vue";
    import GroupExpectation from "./GroupExpectation.vue";

    export default {
        components: {
            AddGroupExpectation,
            GroupExpectation,
        },

        props: {
            initialGroup: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                isAddingNewExpectation: false,
                expectations: [],
            };
        },

        mounted() {
            this.expectations = this.initialGroup.expectations.slice();

            // Broadcasting consumption
            window.Echo.private(`groups.${this.initialGroup.id}`)
                .listen("ExpectationCreated", (e) => {
                    toastr.success("An expectation was created.");

                    this.expectations.push(e.expectation);
                })
                .listen("ExpectationUpdated", (e) => {
                    toastr.success("An expectation was updated.");

                    let index = this.expectations.findIndex(expectation => expectation.id == e.expectation.id);
                    this.$set(this.expectations, index, e.expectation);
                })
                .listen("ExpectationDeleted", (e) => {
                    toastr.success("An expectation was deleted.");

                    let index = this.expectations.findIndex(expectation => expectation.id == e.expectation.id);
                    this.expectations.splice(index, 1);
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
