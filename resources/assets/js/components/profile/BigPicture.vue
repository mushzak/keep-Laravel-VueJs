<template>
    <div class="card mb-3">
        <div class="card-header">Big Picture</div>
        <div class="card-body">
            <b>Vision</b>
            <p class="dmh-preserve-text-area">{{vision}}</p>

            <b>Values</b>
            <p class="dmh-preserve-text-area">{{values}}</p>

            <b>Mission</b>
            <p class="dmh-preserve-text-area">{{mission}}</p>

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
                vision: this.member.vision,
                values: this.member.values,
                mission: this.member.mission,
            };
        },

        mounted() {
            // Broadcasting consumption
            Echo.private(`members.${this.member.id}`)
                .listen("MemberUpdated", (e) => {
                    this.vision = e.member.vision;
                    this.values = e.member.values;
                    this.mission = e.member.mission;
                });
        },

        methods: {
        },
    };
</script>
