<template>
    <div class="card mb-3">
        <div class="card-header">Personal Motivation</div>
        <div class="card-body">
            <b>Why</b>
            <p class="dmh-preserve-text-area">{{why}}</p>
            <b>Consequences</b>
            <p class="dmh-preserve-text-area">{{consequences}}</p>
        </div>
    </div>
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
                why: this.member.why,
                consequences: this.member.consequences,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.why = e.member.why;
                    this.consequences = e.member.consequences;
                });
        },

        methods: {
        },
    };
</script>
