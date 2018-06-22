<template>
        <div class="card mb-3">
            <div class="card-header">Contact Information</div>
            <div class="card-body">
                <div v-if="hasNoData()">
                    <b>No Contact Data</b>
                </div>

                <div v-if="email">
                    <b>Email</b>
                    <p class="dmh-preserve-text-area">{{email}}</p>
                </div>

                <div v-if="phone_1">
                    <b>Phone 1</b>
                    <p class="dmh-preserve-text-area">{{phone_1}}</p>
                </div>

                <div v-if="phone_2">
                    <b>Phone 2</b>
                    <p class="dmh-preserve-text-area">{{phone_2}}</p >
                </div>

                <div v-if="other">
                    <b>Other POCs</b>
                    <p class="dmh-preserve-text-area">{{other}}</p>
                </div>

            </div>
        </div>
    </form>
</template>

<script>
    export default {
        components: {
        },

        props: {
            member: {
                type: Object,
                required: true,
            }
        },

        data() {
            return {
                email: this.member.email,
                other: this.member.other,
                phone_1: this.member.phone_1,
                phone_2: this.member.phone_2,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.email = e.member.email;
                    this.other = e.member.other;
                    this.phone_1 = e.member.phone_1;
                    this.phone_2 = e.member.phone_2;
                });
        },

        methods: {
            hasNoData() {
                return ((this.email+this.other+this.phone_1+this.phone_2)==0);
            }

        },
    };
</script>